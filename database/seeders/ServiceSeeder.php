<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['service_type_id' => 1, 'date' => '2024-05-07', 'time' => '06:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['service_type_id' => 2, 'date' => '2024-05-12', 'time' => '09:00:00', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('services')->insert($default);
    }
}
