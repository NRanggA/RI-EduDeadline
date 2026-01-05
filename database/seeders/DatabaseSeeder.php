<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeders dalam urutan yang tepat untuk menghindari foreign key constraint
        $this->call([
            UserSeeder::class,
            CourseSeeder::class,
            TaskSeeder::class,
            ActivitySeeder::class,
            ThesisDataSeeder::class,
        ]);
    }
}
