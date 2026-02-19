<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $schemaPath = base_path('database/sql/ask_LEIC.sql');
        $schemaSql = file_get_contents($schemaPath);
        DB::unprepared($schemaSql);
        $this->command->info('Database schema seeded!');

        $populatePath = base_path('database/sql/populate.sql');
        $populateSql = file_get_contents($populatePath);
        DB::unprepared($populateSql);
        $this->command->info('Database population seeded!');

    }
}
