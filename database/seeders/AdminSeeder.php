<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {
        DB::table('admins')->delete();

        $admins = [
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@email.com',
                'password' => Hash::make('123456789'),
                'is_active' => 1,
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@email.com',
                'password' => Hash::make('123456789'),
                'is_active' => 1,
            ],
            [
                'name' => 'Manager',
                'username' => 'manager',
                'email' => 'manager@email.com',
                'password' => Hash::make('123456789'),
                'is_active' => 1,
            ],
            [
                'name' => 'Staff',
                'username' => 'staff',
                'email' => 'staff@email.com',
                'password' => Hash::make('123456789'),
                'is_active' => 1,
            ],
        ];

        DB::table('admins')->insert($admins);

        /**
         * Assign Roles to Users
         */

        // Super Admin
        $superAdmin = \App\Models\Admin::find(1);
        $role = Role::where('name', 'super admin')->first();
        $superAdmin->assignRole($role);

        // Admin
        $admin = \App\Models\Admin::find(2);
        $role = Role::where('name', 'admin')->first();
        $admin->assignRole($role);

        // Manager
        $manager = \App\Models\Admin::find(3);
        $role = Role::where('name', 'manager')->first();
        $manager->assignRole($role);

        // Staff
        $staff = \App\Models\Admin::find(4);
        $role = Role::where('name', 'staff')->first();
        $staff->assignRole($role);
    }
}
