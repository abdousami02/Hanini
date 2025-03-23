<?php

namespace Database\Seeders;

use App\Models\SellerProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SellerProfile::upsert([
            ['id' => 1, 'user_id'=> 1, 'name' => 'admin fournisseur', 'email' => 'admin@gmail.com', 'mobile' => '0644556677',
                'address' => '', 'status' => 1]
        ],['id']);
    }
}
