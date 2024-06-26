<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_role')->insert([
            [
                'id' => Str::uuid()->toString(),
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'user',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
