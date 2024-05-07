<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['status' => 'Idle', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'In-Use', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'Running', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'Ended', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('statuses')->insert($default);
    }
}
