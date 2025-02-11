<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::upsert([
            ['id' => 1, 'name' => 'admin', 'email' => 'admin@gmail.com', 'phone' => '0644556677',
                'email_verified_at' => now(), 'password' => Hash::make('123456'),
                'user_type' => 'super_admin', 'status' => 1]
        ],['id']);
    }
}
