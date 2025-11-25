<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Comando para actualizar modelos Laravel con soporte nativo para columnas PostGIS.
 *
 * Este comando detecta automáticamente columnas geometry/geography en PostgreSQL
 * y genera accessors/mutators compatibles con Laravel 12+ sin paquetes externos.
 */
class FixPostgisModels extends Command
{
    protected $signature = 'postgis:fix-models
                            {--dry-run : Muestra los cambios sin aplicarlos}
                            {--model= : Procesar solo un modelo específico}';

    protected $description = 'Genera casts y accessors/mutators para columnas PostGIS sin paquetes externos';

    /**
     * Ejecutar el comando.
     */
    public function handle(): int
    {
        $this->info('Buscando columnas PostGIS en la base de datos...');

        $columns = $this->getPostgisColumns();

        if (empty($columns)) {
            $this->warn('No se encontraron columnas PostGIS.');
            return Command::SUCCESS;
        }

        $this->displayFoundColumns($columns);

        $modelsPath = app_path('Models');
        $processed = 0;
        $errors = 0;
        $specificModel = $this->option('model');

        foreach ($columns as $table => $cols) {
            $modelName = Str::studly(Str::singular($table));

            // Filtrar si se especificó un modelo
            if ($specificModel && $modelName !== $specificModel) {
                continue;
            }

            $modelPath = "{$modelsPath}/{$modelName}.php";

            if (!File::exists($modelPath)) {
                $this->warn("Modelo no encontrado: {$modelName} (tabla: {$table})");
                continue;
            }

            try {
                $this->processModel($modelPath, $modelName, $cols);
                $processed++;
                $this->info("Modelo {$modelName} actualizado: " . implode(', ', $cols));
            } catch (\Exception $e) {
                $errors++;
                $this->error("Error en {$modelName}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info("Proceso completado: {$processed} modelo(s) actualizado(s), {$errors} error(es).");

        return $errors > 0 ? Command::FAILURE : Command::SUCCESS;
    }

    /**
     * Obtener todas las columnas PostGIS de la base de datos.
     */
    protected function getPostgisColumns(): array
    {
        $result = [];

        $cols = DB::select("
            SELECT table_name, column_name, udt_name
            FROM information_schema.columns
            WHERE udt_name IN ('geometry', 'geography')
              AND table_schema = 'public'
            ORDER BY table_name, column_name
        ");

        foreach ($cols as $col) {
            $result[$col->table_name][] = $col->column_name;
        }

        return $result;
    }

    /**
     * Mostrar las columnas encontradas.
     */
    protected function displayFoundColumns(array $columns): void
    {
        $this->newLine();
        $this->table(
            ['Tabla', 'Columnas PostGIS'],
            collect($columns)->map(fn($cols, $table) => [$table, implode(', ', $cols)])->values()->all()
        );
        $this->newLine();
    }

    /**
     * Procesar un modelo individual.
     */
    protected function processModel(string $modelPath, string $modelName, array $columns): void
    {
        $content = File::get($modelPath);
        $originalContent = $content;

        // 1. Asegurar import de DB
        $content = $this->ensureDbImport($content);

        // 2. Limpiar accessors/mutators duplicados o antiguos
        $content = $this->removeExistingPostgisMethods($content, $columns);

        // 3. Actualizar DocBlocks
        $content = $this->updateDocBlocks($content, $columns);

        // 4. Actualizar $casts
        $content = $this->updateCasts($content, $columns);

        // 5. Generar accessor/mutator unificado (estilo Laravel 9+)
        $content = $this->insertAccessorMutators($content, $columns);

        // Guardar cambios
        if ($this->option('dry-run')) {
            $this->line("--- {$modelName} (dry-run) ---");
            $this->line($content);
            return;
        }

        if ($content !== $originalContent) {
            File::put($modelPath, $content);
        }
    }

    /**
     * Asegurar que el import de DB esté presente.
     */
    protected function ensureDbImport(string $content): string
    {
        $dbImport = 'use Illuminate\Support\Facades\DB;';

        if (str_contains($content, $dbImport)) {
            return $content;
        }

        // Insertar después del último use statement
        if (preg_match('/^(use\s+[^;]+;)\s*$/m', $content, $matches, PREG_OFFSET_CAPTURE)) {
            // Encontrar la última línea use
            preg_match_all('/^use\s+[^;]+;\s*$/m', $content, $allUses, PREG_OFFSET_CAPTURE);
            if (!empty($allUses[0])) {
                $lastUse = end($allUses[0]);
                $insertPos = $lastUse[1] + strlen($lastUse[0]);
                $content = substr($content, 0, $insertPos) . $dbImport . "\n" . substr($content, $insertPos);
            }
        }

        return $content;
    }

    /**
     * Eliminar métodos PostGIS existentes para regenerarlos.
     */
    protected function removeExistingPostgisMethods(string $content, array $columns): string
    {
        foreach ($columns as $column) {
            $camelColumn = Str::camel($column);
            $studlyColumn = Str::studly($column);

            // Eliminar accessor moderno con Attribute (maneja llaves anidadas)
            $content = $this->removeMethodByName($content, $camelColumn);

            // Eliminar mutator legacy: setUbicacionAttribute
            $content = $this->removeMethodByName($content, "set{$studlyColumn}Attribute");

            // Eliminar versión con nombre incorrecto (todo minúsculas)
            $content = $this->removeMethodByName($content, "set{$column}Attribute");
        }

        // Limpiar múltiples líneas vacías consecutivas
        $content = preg_replace('/\n{3,}/', "\n\n", $content);

        return $content;
    }

    /**
     * Eliminar un método por su nombre, manejando llaves anidadas correctamente.
     */
    protected function removeMethodByName(string $content, string $methodName): string
    {
        // Buscar la posición del método
        $pattern = '/(\n\s*(?:\/\*\*[\s\S]*?\*\/\s*)?)((public|protected|private)\s+function\s+' . preg_quote($methodName, '/') . '\s*\([^)]*\))/';

        if (!preg_match($pattern, $content, $match, PREG_OFFSET_CAPTURE)) {
            return $content;
        }

        $startPos = $match[1][1]; // Inicio incluyendo DocBlock opcional
        $afterSignature = $match[0][1] + strlen($match[0][0]);

        // Buscar la llave de apertura
        $bracePos = strpos($content, '{', $afterSignature);
        if ($bracePos === false) {
            return $content;
        }

        // Encontrar la llave de cierre correspondiente
        $endPos = $this->findMatchingBrace($content, $bracePos);
        if ($endPos === false) {
            return $content;
        }

        // Eliminar el método completo (incluyendo espacios después)
        $endPos++;
        while ($endPos < strlen($content) && in_array($content[$endPos], ["\n", "\r", " ", "\t"])) {
            $endPos++;
        }

        return substr($content, 0, $startPos) . "\n" . substr($content, $endPos);
    }

    /**
     * Encontrar la llave de cierre que corresponde a la llave de apertura.
     */
    protected function findMatchingBrace(string $content, int $openPos): int|false
    {
        $depth = 0;
        $len = strlen($content);
        $inString = false;
        $stringChar = '';

        for ($i = $openPos; $i < $len; $i++) {
            $char = $content[$i];
            $prevChar = $i > 0 ? $content[$i - 1] : '';

            // Manejar strings
            if (!$inString && ($char === '"' || $char === "'")) {
                $inString = true;
                $stringChar = $char;
            } elseif ($inString && $char === $stringChar && $prevChar !== '\\') {
                $inString = false;
            }

            if (!$inString) {
                if ($char === '{') {
                    $depth++;
                } elseif ($char === '}') {
                    $depth--;
                    if ($depth === 0) {
                        return $i;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Actualizar DocBlocks reemplazando USER-DEFINED por array|null.
     */
    protected function updateDocBlocks(string $content, array $columns): string
    {
        foreach ($columns as $column) {
            // Reemplazar USER-DEFINED|null o USER-DEFINED
            $patterns = [
                "/@property\s+USER-DEFINED\|null\s+\\\${$column}\b/",
                "/@property\s+USER-DEFINED\s+\\\${$column}\b/",
                "/@property\s+mixed\|null\s+\\\${$column}\b/",
                "/@property\s+mixed\s+\\\${$column}\b/",
            ];

            foreach ($patterns as $pattern) {
                $content = preg_replace($pattern, "@property array|null \${$column}", $content);
            }
        }

        return $content;
    }

    /**
     * Actualizar la propiedad $casts.
     */
    protected function updateCasts(string $content, array $columns): string
    {
        // Extraer casts existentes
        $existingCasts = $this->extractCasts($content);

        // Actualizar columnas PostGIS a 'array'
        foreach ($columns as $column) {
            $existingCasts[$column] = "'array'";
        }

        // Generar nuevo bloque $casts
        $newCastsBlock = $this->generateCastsBlock($existingCasts);

        // Reemplazar $casts existente
        if (preg_match('/protected\s+\$casts\s*=\s*\[.*?\];/s', $content)) {
            $content = preg_replace('/protected\s+\$casts\s*=\s*\[.*?\];/s', $newCastsBlock, $content);
        } else {
            // Insertar después de $table
            $content = preg_replace(
                '/(protected\s+\$table\s*=\s*[\'"][^\'"]+[\'"];)/',
                "$1\n\n    {$newCastsBlock}",
                $content
            );
        }

        return $content;
    }

    /**
     * Extraer el array $casts existente del modelo.
     */
    protected function extractCasts(string $content): array
    {
        $casts = [];

        if (preg_match('/protected\s+\$casts\s*=\s*\[(.*?)\];/s', $content, $match)) {
            $castsContent = $match[1];

            // Parsear cada entrada del array
            preg_match_all("/['\"]([^'\"]+)['\"]\s*=>\s*([^,\]]+)/", $castsContent, $matches, PREG_SET_ORDER);

            foreach ($matches as $m) {
                $key = $m[1];
                $value = trim($m[2]);

                // Normalizar valores
                if ($value === 'array' || $value === "'array'" || $value === '"array"') {
                    $value = "'array'";
                } elseif (!str_starts_with($value, "'") && !str_starts_with($value, '"') && !str_contains($value, '::')) {
                    // Es un valor sin comillas (probablemente un error), agregar comillas
                    $value = "'{$value}'";
                }

                $casts[$key] = $value;
            }
        }

        return $casts;
    }

    /**
     * Generar el bloque $casts formateado.
     */
    protected function generateCastsBlock(array $casts): string
    {
        if (empty($casts)) {
            return "protected \$casts = [];";
        }

        $lines = ["protected \$casts = ["];

        foreach ($casts as $key => $value) {
            $lines[] = "        '{$key}' => {$value},";
        }

        $lines[] = "    ];";

        return implode("\n", $lines);
    }

    /**
     * Insertar accessors/mutators unificados al final de la clase.
     */
    protected function insertAccessorMutators(string $content, array $columns): string
    {
        $methods = [];

        foreach ($columns as $column) {
            $methods[] = $this->generateUnifiedAccessorMutator($column);
        }

        $methodsCode = implode("\n", $methods);

        // Insertar antes de la última llave de cierre de la clase
        $content = preg_replace('/}\s*$/', $methodsCode . "\n}\n", $content);

        return $content;
    }

    /**
     * Generar accessor/mutator unificado usando Attribute (Laravel 9+).
     */
    protected function generateUnifiedAccessorMutator(string $column): string
    {
        $camelColumn = Str::camel($column);

        return <<<PHP

    /**
     * Accessor/Mutator para la columna PostGIS '{$column}'.
     *
     * - Get: Convierte geometría PostGIS a array GeoJSON.
     * - Set: Acepta ['lat' => ..., 'lng' => ...] o null.
     */
    protected function {$camelColumn}(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function (\$value) {
                if (\$value === null) {
                    return null;
                }

                try {
                    \$result = DB::selectOne("SELECT ST_AsGeoJSON(?) AS geojson", [\$value]);
                    return \$result ? json_decode(\$result->geojson, true) : null;
                } catch (\Exception \$e) {
                    return null;
                }
            },
            set: function (\$value) {
                if (\$value === null) {
                    return null;
                }

                if (!is_array(\$value) || !isset(\$value['lat'], \$value['lng'])) {
                    return null;
                }

                \$lat = (float) \$value['lat'];
                \$lng = (float) \$value['lng'];

                return DB::raw("ST_SetSRID(ST_MakePoint({\$lng}, {\$lat}), 4326)");
            }
        );
    }
PHP;
    }
}
