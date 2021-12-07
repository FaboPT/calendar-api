<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'interviewer',
                'guard_name' => 'api',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'candidate',
                'guard_name' => 'api',
                'created_at' => now(),
                'updated_at' => now(),

            ],
        ]);
    }
}
