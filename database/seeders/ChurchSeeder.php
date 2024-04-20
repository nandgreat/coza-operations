<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChurchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['church_name' => 'Guzape Church (HQ)', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Maraba Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Gwagwalada Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Kuje Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'FHA Lugbe Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Gwarimpa Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Karu Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Kubwa Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Wuse Zone 5 Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Maitama Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Keffi Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Ilorin Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Lagos Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Port-Harcourt Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Manchester Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Birmingham Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['church_name' => 'Dubai Church', 'city_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('churches')->insert($default);
    }
}
