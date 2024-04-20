<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['attendance_status' => 'Attended', 'created_at' => now(), 'updated_at' => now()],
            ['attendance_status' => 'Missed', 'created_at' => now(), 'updated_at' => now()],

        ];

        DB::table('attendance_statuses')->insert($default);
    }
}
