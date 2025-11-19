<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use KitLoong\MigrationsGenerator\Migration\Generator\Modifiers\DefaultModifier;
use KitLoong\MigrationsGenerator\Migration\Blueprint\Method;
use KitLoong\MigrationsGenerator\Schema\Models\Column;
use Illuminate\Support\Facades\DB;

class MigrationGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Override el DefaultModifier para manejar funciones de PostgreSQL
        $this->app->extend(DefaultModifier::class, function ($modifier, $app) {
            return new class($app->make('db')) extends DefaultModifier {
                public function generate(Method $method, Column $column): Method
                {
                    // Si no tiene default, retornar sin modificar
                    if ($column->getDefault() === null) {
                        return $method;
                    }

                    $default = $column->getDefault();

                    // Lista de funciones de PostgreSQL que necesitan DB::raw()
                    $pgFunctions = [
                        'uuid_generate_v4()',
                        'gen_random_uuid()',
                        'now()',
                        'current_timestamp',
                        'current_date',
                        'current_time',
                    ];

                    // Verificar si el default es una función de PostgreSQL
                    foreach ($pgFunctions as $func) {
                        if (stripos($default, $func) !== false || preg_match('/^[a-z_]+\(.+\)$/i', $default)) {
                            // Usar DB::raw() para funciones
                            $method->chain('default', DB::raw($default));
                            return $method;
                        }
                    }

                    // Para otros casos, usar el comportamiento original
                    return parent::generate($method, $column);
                }
            };
        });
    }

    public function register()
    {
        //
    }
}
