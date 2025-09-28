<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin user
        $admin = User::firstOrCreate(
            [
                'username' => 'admin_1',
                'email' => 'admin1@example.com'
            ], // check if existing username, email
            [
                'name' => 'Admin 1',
                'password' => bcrypt('1234qweR'),
            ]
        );

        // Create Admin role if not exists
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Assign role to user
        $admin->assignRole($role);

        // Assign permissions to user
        // $admin->givePermissionTo(Permission::all());
        $admin->givePermissionTo($role->permissions);
    }
}
