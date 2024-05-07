<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['service_type' => 'Sunday Service', 'created_at' => now(), 'updated_at' => now()],
            ['service_type' => 'Tuesday Service', 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('service_types')->insert($default);
    }
}
