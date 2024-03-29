<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::beginTransaction();
        try {
            $admin = User::create(
                [
                    'name' => 'Admin IT',
                    'username' => 'Admin',
                    'password' => bcrypt('123'),
                ]
            );

            $superadmin = User::create(
                [
                    'name' => 'Manager',
                    'username' => 'Superadmin',
                    'password' => bcrypt('123'),
                ]
            );

            $warehouse = User::create(
                [
                    'name' => 'Warehouse',
                    'username' => 'Warehouse',
                    'password' => bcrypt('123'),
                ]
            );

            $purchasing = User::create(
                [
                    'name' => 'Purchasing',
                    'username' => 'Purchase',
                    'password' => bcrypt('123'),
                ]
            );

            $testing = User::create(
                [
                    'name' => 'Testing',
                    'username' => 'Test',
                    'password' => bcrypt('123'),
                ]
                );

            $role_admin = Role::create(['name' => 'admin']);
            $role_superadmin = Role::create(['name' => 'superadmin']);
            $role_warehouse = Role::create(['name' => 'warehouse']);
            $role_purchasing = Role::create(['name' => 'purchasing']);
            $role_testing = Role::create(['name' => 'testing']);

            $permissions = [
                [
                    'name' => 'read role'
                ],
                [
                    'name' => 'create role'
                ],
                [
                    'name' => 'update role'
                ],
                [
                    'name' => 'delete role'
                ],
            ];

            foreach ($permissions as $permission) {
                Permission::create($permission);
            }

            $admin->assignRole('admin');
            $role_admin->givePermissionTo(Permission::all());

            $superadmin->assignRole('superadmin');
            $warehouse->assignRole('warehouse');
            $purchasing->assignRole('purchasing');

            $testing->assignRole('testing');
            $role_testing->givePermissionTo(Permission::all());

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
