<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Seed roles
        $rolesData = [
            ['guard_name' => 'admin', 'name' => 'super admin'],
            ['guard_name' => 'admin', 'name' => 'admin'],
            ['guard_name' => 'admin', 'name' => 'manager'],
            ['guard_name' => 'admin', 'name' => 'staff'],
        ];

        foreach ($rolesData as $roleData) {
            Role::create($roleData);
        }

        // Seed permissions
        $this->createPermissions();

        // Assign permissions to roles
        $superAdmin = Role::where('name', 'super admin')->first();
        $admin = Role::where('name', 'admin')->first();
        $manager = Role::where('name', 'manager')->first();
        $staff = Role::where('name', 'staff')->first();

        // Give Permission
        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo(Permission::all());
        $staff->givePermissionTo(Permission::all());
    }

    /**
     * Create permissions.
     */
     private function createPermissions(): void
    {
        /**
         * Read Permissions
         */
        $read_permissions = [
            ['guard_name' => 'admin',  'name' => 'client read'],
        ];
        foreach ($read_permissions as $permissionData) {
            Permission::create($permissionData);
        }

        /**
         * Create Permissions
         */
        $create_permissions = [
            ['guard_name' => 'admin',  'name' => 'client create'],
        ];
        foreach ($create_permissions as $permissionData) {
            Permission::create($permissionData);
        }

        /**
         * Update Permissions
         */
        $update_permissions = [
            ['guard_name' => 'admin',  'name' => 'client update'],
        ];
        foreach ($update_permissions as $permissionData) {
            Permission::create($permissionData);
        }

        /**
         * Delete Permissions
         */
        $delete_permissions = [
            ['guard_name' => 'admin',  'name' => 'client delete'],
        ];
        foreach ($delete_permissions as $permissionData) {
            Permission::create($permissionData);
        }
    }
}