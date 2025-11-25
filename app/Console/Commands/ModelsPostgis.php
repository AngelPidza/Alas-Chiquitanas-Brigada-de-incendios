<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ModelsPostgis extends Command
{
    protected $signature = 'models:postgis';
    protected $description = 'Agrega soporte PostGIS a los modelos generados automáticamente';

    protected $postgisTypes = [
        'geography',
        'geometry',
        'point',
        'geography(point,4326)',
    ];

    public function handle()
    {
        $modelsPath = app_path('Models');

        $files = File::allFiles($modelsPath);

        foreach ($files as $file) {
            $content = File::get($file->getRealPath());
            $modelName = $file->getFilenameWithoutExtension();

            // Si ya contiene el trait, saltar
            if (Str::contains($content, 'HasPostgisColumns')) {
                $this->info("$modelName ya tiene trait PostGIS");
                continue;
            }

            // Detectar columnas PostGIS por docblock (USER-DEFINED o similar)
            $postgisColumns = [];
            foreach ($this->postgisTypes as $type) {
                if (Str::contains($content, $type)) {
                    preg_match_all("/@property\s+[^\s]+\s+\$([^\s]+)/", $content, $matches);
                    foreach ($matches[1] as $column) {
                        $postgisColumns[$column] = [
                            'type' => 'geography',
                            'srid' => 4326,
                        ];
                    }
                }
            }

            if (!empty($postgisColumns)) {
                // Insertar trait
                $content = str_replace('extends Model', "extends Model\n{\n    use \Clickbar\Magellan\Eloquent\HasPostgisColumns;", $content);

                // Insertar propiedad $postgisColumns
                $columnsArray = var_export($postgisColumns, true);
                $columnsString = "\n    protected array \$postgisColumns = $columnsArray;\n";
                $content = preg_replace("/\{/", "{\n$columnsString", $content, 1);

                // Insertar cast
                $content = preg_replace("/protected \$casts = \[.*?\];/s", "protected \$casts = [\n        'ubicacion' => \Clickbar\Magellan\Types\Point::class,\n    ];", $content);

                File::put($file->getRealPath(), $content);

                $this->info("PostGIS agregado a $modelName");
            }
        }

        $this->info("Proceso completado.");
    }
}
