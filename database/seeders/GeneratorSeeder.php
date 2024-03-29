<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $default = [
            ['generator_name' => 'Perkins', 'created_at' => now(), 'updated_at' => now()],
            ['generator_name' => 'Cat', 'created_at' => now(), 'updated_at' => now()],
            ['generator_name' => 'Jubaili', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('generators')->insert($default);
    }
}
