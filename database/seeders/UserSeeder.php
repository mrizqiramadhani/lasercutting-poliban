<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRoleId = DB::table('m_role')->where('name', 'admin')->value('id');

        DB::table('m_user')->insert([
            'id' => Str::uuid()->toString(),
            'role_id' => $adminRoleId,
            'name' => 'admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('demoadmin'),
            'created_at' => now(),
            'updated_at' => now()

        ]);
    }
}
