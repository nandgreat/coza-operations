<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DieselLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $default = [
            ['diesel_level' => 1570, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('diesel_levels')->insert($default);
    }
}
