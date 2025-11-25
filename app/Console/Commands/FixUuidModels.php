<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Comando para corregir modelos Laravel con claves primarias UUID.
 *
 * Detecta automáticamente tablas con columnas UUID y asegura que los modelos
 * correspondientes tengan $keyType = 'string' para evitar errores de cast.
 */
class FixUuidModels extends Command
{
    protected $signature = 'uuid:fix-models
                            {--dry-run : Muestra los cambios sin aplicarlos}
                            {--model= : Procesar solo un modelo específico}';

    protected $description = 'Corrige modelos con UUID agregando $keyType = string';

    /**
     * Ejecutar el comando.
     */
    public function handle(): int
    {
        $this->info('Buscando tablas con columnas UUID...');

        $tables = $this->getTablesWithUuidPrimaryKey();

        if (empty($tables)) {
            $this->warn('No se encontraron tablas con UUID como clave primaria.');
            return Command::SUCCESS;
        }

        $this->displayFoundTables($tables);

        $modelsPath = app_path('Models');
        $processed = 0;
        $skipped = 0;
        $errors = 0;
        $specificModel = $this->option('model');

        foreach ($tables as $table) {
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
                $result = $this->processModel($modelPath, $modelName);
                if ($result === 'updated') {
                    $processed++;
                    $this->info("Modelo {$modelName} actualizado");
                } else {
                    $skipped++;
                    $this->line("Modelo {$modelName} ya está correcto");
                }
            } catch (\Exception $e) {
                $errors++;
                $this->error("Error en {$modelName}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info("Proceso completado: {$processed} actualizado(s), {$skipped} sin cambios, {$errors} error(es).");

        return $errors > 0 ? Command::FAILURE : Command::SUCCESS;
    }

    /**
     * Obtener todas las tablas con UUID como clave primaria.
     */
    protected function getTablesWithUuidPrimaryKey(): array
    {
        $tables = [];

        // Obtener tablas con columna 'id' de tipo uuid
        $result = DB::select("
            SELECT table_name
            FROM information_schema.columns
            WHERE table_schema = 'public'
              AND column_name = 'id'
              AND udt_name = 'uuid'
            ORDER BY table_name
        ");

        foreach ($result as $row) {
            $tables[] = $row->table_name;
        }

        return $tables;
    }

    /**
     * Mostrar las tablas encontradas.
     */
    protected function displayFoundTables(array $tables): void
    {
        $this->newLine();
        $this->table(
            ['Tabla con UUID'],
            array_map(fn($t) => [$t], $tables)
        );
        $this->newLine();
    }

    /**
     * Procesar un modelo individual.
     */
    protected function processModel(string $modelPath, string $modelName): string
    {
        $content = File::get($modelPath);
        $originalContent = $content;

        // Verificar si ya tiene $keyType
        if (preg_match('/protected\s+\$keyType\s*=/', $content)) {
            return 'skipped';
        }

        // Agregar $keyType = 'string' después de $incrementing = false
        if (preg_match('/(public\s+\$incrementing\s*=\s*false\s*;)/', $content)) {
            $content = preg_replace(
                '/(public\s+\$incrementing\s*=\s*false\s*;)/',
                "$1\n\tprotected \$keyType = 'string';",
                $content
            );
        } else {
            // Si no existe $incrementing, agregar ambos después de $table
            $content = preg_replace(
                '/(protected\s+\$table\s*=\s*[\'"][^\'"]+[\'"];)/',
                "$1\n\tpublic \$incrementing = false;\n\tprotected \$keyType = 'string';",
                $content
            );
        }

        // Guardar cambios
        if ($this->option('dry-run')) {
            $this->line("--- {$modelName} (dry-run) ---");
            $this->line($content);
            return 'updated';
        }

        if ($content !== $originalContent) {
            File::put($modelPath, $content);
            return 'updated';
        }

        return 'skipped';
    }
}
