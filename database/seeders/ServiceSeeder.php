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
            ['service_name' => 'DPE', 'date' => now(), 'time' => '06:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['service_name' => 'Sunday Service', 'date' => now(), 'time' => '09:00:00', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('services')->insert($default);
    }
}
