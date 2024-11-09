<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'testAdmin',
            'email' => 'testingAdmin@gmail.com',
            'level' => User::ROLE_ADMIN, // Ensure this matches the admin role constant
            'password' => Hash::make('12345678'), // Use a secure password
        ]);
    }
}
