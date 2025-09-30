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
            'view users',
            'create users',
            'edit users',

            'view categories',
            'create categories',
            'edit categories',

            'view books',
            'create books',
            'edit books',

            'view orders',

            'approve sellers'
        ];


        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }


        $admin = Role::firstOrCreate(['name' => 'Admin']);
        // $admin->givePermissionTo(Permission::all());
        $admin->givePermissionTo([
            'view users',
            'create users',
            'edit users',

            'view categories',
            'create categories',
            'edit categories',

            'view books',
            'view orders',

            'approve sellers'
        ]);


        $seller = Role::firstOrCreate(['name' => 'Seller']);
        $seller->givePermissionTo([
            'view books',
            'create books',
            'edit books',
            'view orders'
        ]);

        $buyer = Role::firstOrCreate(['name' => 'Buyer']);
        $buyer->givePermissionTo([
            'view books',
            'view orders'
        ]);
    }
}
