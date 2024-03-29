<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalAdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $default = [
            ['approval_admin' => 'GSP', 'created_at' => now(), 'updated_at' => now()],
            ['approval_admin' => 'GSPM', 'created_at' => now(), 'updated_at' => now()],
            ['approval_admin' => 'Bro Stanley', 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('approval_admins')->insert($default);
    }
}
