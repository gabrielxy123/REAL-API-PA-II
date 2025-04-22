<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'ADMIN LAUNDRY',
                'email' => 'carilaundry@gmail.com',
                'noTelp' => '082211245678',
                'password' => Hash::make('welcharbunpatpan08'),
                'role' => 'admin',
                'created_at'=> now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
