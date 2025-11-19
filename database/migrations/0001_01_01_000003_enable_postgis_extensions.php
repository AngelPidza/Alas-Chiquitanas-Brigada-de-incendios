<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Enable PostGIS extension for geospatial data
        DB::statement('CREATE EXTENSION IF NOT EXISTS postgis');

        // Enable UUID extension for UUID generation
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop extensions as they might be used by other databases
        // DB::statement('DROP EXTENSION IF EXISTS postgis');
        // DB::statement('DROP EXTENSION IF EXISTS "uuid-ossp"');
    }
};
