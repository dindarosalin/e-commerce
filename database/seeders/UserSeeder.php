<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password')
        ]);
    
        $superadmin->assignRole('Super Admin');
    
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);
    
        $admin->assignRole('Admin');

        $seller = \App\Models\User::create([
            'name' => 'seller',
            'email' => 'seller@gmail.com',
            'password' => bcrypt('password')
        ]);
    
        $seller->assignRole('Seller');

        $buyer = \App\Models\User::create([
            'name' => 'buyer',
            'email' => 'buyer@gmail.com',
            'password' => bcrypt('password')
        ]);
    
        $buyer->assignRole('Buyer');
    }
}
