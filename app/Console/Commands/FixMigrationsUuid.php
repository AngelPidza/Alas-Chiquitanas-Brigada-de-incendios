<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixMigrationsUuid extends Command
{
    protected $signature = 'migrations:fix-uuid
                            {--path= : The path to the migrations folder}
                            {--dry-run : Preview changes without modifying files}';

    protected $description = 'Fix UUID defaults in migrations to use DB::raw() for PostgreSQL functions';

    public function handle()
    {
        $path = $this->option('path') ?: database_path('migrations');
        $dryRun = $this->option('dry-run');

        if (!File::isDirectory($path)) {
            $this->error("Directory not found: {$path}");
            return 1;
        }

        $files = File::files($path);
        $fixed = 0;
        $errors = 0;

        $this->info("Scanning migrations in: {$path}");
        $this->newLine();

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $content = File::get($file->getPathname());
            $original = $content;

            // Pattern: ->default('function_name()') - PostgreSQL functions that need DB::raw()
            $pgFunctions = [
                'uuid_generate_v4',
                'gen_random_uuid',
                'now',
                'current_timestamp',
                'current_date',
                'current_time',
            ];

            foreach ($pgFunctions as $func) {
                $pattern = "/->default\(['\"](". preg_quote($func, '/') ."\(\))['\"]\)/i";
                $replacement = $func . '()';
                $content = preg_replace(
                    $pattern,
                    "->default(DB::raw('{$replacement}'))",
                    $content
                );
            }

            // Ensure DB facade is imported if we made changes
            if ($content !== $original && !str_contains($content, 'use Illuminate\Support\Facades\DB;')) {
                // Add DB import after Schema import
                $content = preg_replace(
                    '/(use Illuminate\\\\Database\\\\Schema\\\\Blueprint;)/m',
                    "$1\nuse Illuminate\\Support\\Facades\\DB;",
                    $content
                );
            }

            if ($content !== $original) {
                $fixed++;

                if ($dryRun) {
                    $this->warn("Would fix: {$file->getFilename()}");
                    $this->line($this->getDiff($original, $content));
                } else {
                    try {
                        File::put($file->getPathname(), $content);
                        $this->info("✓ Fixed: {$file->getFilename()}");
                    } catch (\Exception $e) {
                        $this->error("✗ Error fixing {$file->getFilename()}: {$e->getMessage()}");
                        $errors++;
                    }
                }
            }
        }

        $this->newLine();

        if ($dryRun) {
            $this->info("Dry run completed. {$fixed} file(s) would be fixed.");
        } else {
            $this->info("Completed! {$fixed} file(s) fixed, {$errors} error(s).");
        }

        return $errors > 0 ? 1 : 0;
    }

    private function getDiff(string $original, string $new): string
    {
        // Simple diff preview showing changed lines
        $originalLines = explode("\n", $original);
        $newLines = explode("\n", $new);

        $diff = [];
        for ($i = 0; $i < max(count($originalLines), count($newLines)); $i++) {
            $origLine = $originalLines[$i] ?? '';
            $newLine = $newLines[$i] ?? '';

            if ($origLine !== $newLine && str_contains($newLine, 'DB::raw')) {
                $diff[] = "  - " . trim($origLine);
                $diff[] = "  + " . trim($newLine);
            }
        }

        return implode("\n", $diff);
    }
}
