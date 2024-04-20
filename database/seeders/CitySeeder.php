<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['city_name' => 'Abuja', 'created_at' => now(), 'updated_at' => now()],
            ['city_name' => 'Lagos', 'created_at' => now(), 'updated_at' => now()],
            ['city_name' => 'Ilorin', 'created_at' => now(), 'updated_at' => now()],
            ['city_name' => 'Port-Harcourt', 'created_at' => now(), 'updated_at' => now()],
            ['city_name' => 'Manchester', 'created_at' => now(), 'updated_at' => now()],
            ['city_name' => 'Birmingham', 'created_at' => now(), 'updated_at' => now()],
            ['city_name' => 'Dubai', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('cities')->insert($default);
    }
}
