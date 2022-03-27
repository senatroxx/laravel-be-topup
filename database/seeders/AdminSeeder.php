<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory()->create([
            'first_name' => 'Athhar',
            'last_name' => 'Kautsar',
            'username' => 'Senatroxx',
            'email' => 'athharkautsar14@gmail.com',
            'phone_number' => '+628811791089',
            'password' => bcrypt('password'),
        ]);
    }
}
