<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'create-suppliers', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit-suppliers', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete-suppliers', 'guard_name' => 'web']);
        Permission::create(['name' => 'create-customers', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit-customers', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete-customers', 'guard_name' => 'web']);
        Permission::create(['name' => 'create-transactions', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit-transactions', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete-transactions', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-transaction-history', 'guard_name' => 'web']);


        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            'create-suppliers', 'edit-suppliers', 'delete-suppliers',
            'create-customers', 'edit-customers', 'delete-customers',
            'create-transactions', 'edit-transactions', 'delete-transactions',
            'view-transaction-history',
        ]);

        $employeeRole = Role::create(['name' => 'employee', 'guard_name' => 'web']);
        $employeeRole->givePermissionTo([
            'create-transactions', 'edit-transactions', 'delete-transactions',
            'view-transaction-history',
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole('employee');
    }
}
