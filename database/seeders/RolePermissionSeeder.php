<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Spatie 'roles'
        $managerRole = Role::create(['name' => 'manager']);
        $userRole = Role::create(['name' => 'user']);


        // Create Spatie 'permissions'
        $permissions = [
            'create tasks', // 'manager'
            'assign tasks', // 'manager'
            'update tasks', // 'manager'
            'view all tasks', // 'manager'
            'view assigned tasks', // 'user'
            'update assigned task status' // 'user'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        // Assign Spatie 'permissions' to 'roles'
        $managerRole->givePermissionTo([
            'create tasks', // 'manager'
            'assign tasks', // 'manager'
            'update tasks', // 'manager'
            'view all tasks', // 'manager'
        ]);

        $userRole->givePermissionTo([
            'view assigned tasks', // 'user'
            'update assigned task status' // 'user'
        ]);
    }
}
