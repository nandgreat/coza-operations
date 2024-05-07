<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Church;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            DepartmentSeeder::class,
            CitySeeder::class,
            ServiceStatusSeeder::class,
            ServiceTypeSeeder::class,
            ServiceSeeder::class,
            ChurchSeeder::class,
            StatusSeeder::class,
            DieselLevelSeeder::class,
            KeySeeder::class,
            ApprovalAdminsSeeder::class,
            GeneratorPurposeSeeder::class,
            GeneratorSeeder::class
        ]);
    }
}
