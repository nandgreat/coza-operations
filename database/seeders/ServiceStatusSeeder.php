<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['service_status' => 'Not Started', 'created_at' => now(), 'updated_at' => now()],
            ['service_status' => 'Ongoing', 'created_at' => now(), 'updated_at' => now()],
            ['service_status' => 'Ended', 'created_at' => now(), 'updated_at' => now()],

        ];

        DB::table('service_statuses')->insert($default);
    }
}
