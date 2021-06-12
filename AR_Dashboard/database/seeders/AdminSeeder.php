<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Hemran Akhtari',
            'email' => 'hemran@outlook.de',
            'password' => Hash::make('test123'),
            'type' => 'admin',
            'profile_image' => 'default-avatar.jpg',
        ]);
    }
}
