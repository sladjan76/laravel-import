<?php
namespace Database\Seeders;

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
        Permission::create(['name' => 'users_manage']);
        Permission::create(['name' => 'import_orders']);
        Permission::create(['name' => 'import_products']);
    }
}
