<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Manager',
                'username' => 'Admin',
                'role' => 0,
                'password' => bcrypt('admin123'),
            ],
            [
                'name' => 'Admin Sistem',
                'username' => 'Superadmin',
                'role' => 1,
                'password' => bcrypt('sadmin123'),
            ],
            [
                'name' => 'Warehouse',
                'username' => 'Warehouse',
                'role' => 2,
                'password' => bcrypt('whouse123'),
            ],
            [
                'name' => 'Purchasing',
                'username' => 'Purchase',
                'role' => 3,
                'password' => bcrypt('pchase123'),
            ],
            [
                'name' => 'TRM',
                'username' => 'trm',
                'role' => 4,
                'password' => bcrypt('trm123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
