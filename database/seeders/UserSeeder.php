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
        $users = [
            [
                'name' => 'Admin',
                // 'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => Hash::make('12345678'),
                'preferred_timezone' => 'Asia/Jakarta',
            ],
            [
                'name' => 'User 1',
                // 'email' => 'user1@gmail.com',
                'username' => 'user1',
                'password' => Hash::make('12345678'),
                'preferred_timezone' => 'Pacific/Auckland',
            ],
            [
                'name' => 'User 2',
                // 'email' => 'user2@gmail.com',
                'username' => 'user2',
                'password' => Hash::make('12345678'),
                'preferred_timezone' => 'Europe/Berlin',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
