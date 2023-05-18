<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $arrayOfPermissionNames = [
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
        ];
    $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
        return ['name' => $permission, 'guard_name' => 'web'];
    });

    Permission::insert($permissions->toArray());
    }
}
