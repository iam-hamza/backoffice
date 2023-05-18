<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo([
            'roles.index',
            'roles.show',
            'roles.update',
            'users.index',
            'users.store',
            'users.show',
            'users.update',
            'users.destroy',
            'banners.index',
            'banners.store',
            'banners.update',
            'banners.destroy',
            'reseller.index',
        ]);

        $role1 = Role::create(['name' => 'user']);
        
        
    }
}
