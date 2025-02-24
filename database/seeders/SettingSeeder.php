<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path   = base_path('public/wilayas.json');
        $states    = json_decode(file_get_contents($path));
        // echo json_decode($states);

        Setting::insert(['key' => 'state', 'value' => json_encode($states)]);
    }
}
