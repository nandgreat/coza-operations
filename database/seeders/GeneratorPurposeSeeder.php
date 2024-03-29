<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneratorPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $default = [
            ['generator_purpose' => 'DPE', 'created_at' => now(), 'updated_at' => now()],
            ['generator_purpose' => 'Sunday Service', 'created_at' => now(), 'updated_at' => now()],
            ['generator_purpose' => 'Tuesday Service', 'created_at' => now(), 'updated_at' => now()],
            ['generator_purpose' => '12DG Service', 'created_at' => now(), 'updated_at' => now()],
            ['generator_purpose' => '7DG Service', 'created_at' => now(), 'updated_at' => now()],
            ['generator_purpose' => 'CGWC', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('generator_purposes')->insert($default);
    }
}
