<?php
namespace Database\Seeders;

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
        $role->givePermissionTo('users_manage');
        $role->givePermissionTo('import_orders');
        $role->givePermissionTo('import_products');

        $role1 = Role::create(['name' => 'orders importer']);
        $role1->givePermissionTo('import_orders');

    }
}
