<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'role' => 0,
                'level' => 'admin',
            ],
            [
                'role' => 1,
                'level' => 'superadmin',
            ],
            [
                'role' => 2,
                'level' => 'warehouse',
            ],
            [
                'role' => 3,
                'level' => 'purchasing',
            ],
            [
                'role' => 4,
                'level' => 'trm',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
