<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'manage users',
            'manage categories',
            'approve sellers',
            'manage all books',
            'view all orders',
            'create book',
            'edit own book',
            'delete own book',
            'view own orders',
            'update profile'
        ];


        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }


        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());


        $seller = Role::firstOrCreate(['name' => 'Seller']);
        $seller->givePermissionTo(['create book', 'edit own book', 'delete own book', 'view own orders', 'update profile']);
    }
}
