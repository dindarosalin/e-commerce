<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'district list',
                'guard_name' => 'web'
            ],
            [
                'name' => 'create district',
                'guard_name' => 'web'
            ],
            [
                'name' => 'edit district',
                'guard_name' => 'web'
            ],
            [
                'name' => 'delete district',
                'guard_name' => 'web'
            ],
            [
                'name' => 'cek ongkir',
                'guard_name' => 'web'
            ]
        ];

        \DB::table('permissions')->insert($data);

    }
}
