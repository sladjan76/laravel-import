<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('administrator');

        $user1 = User::create([
            'name' => 'Sladjan Dugic',
            'email' => 'sladjan@libero.it',
            'password' => bcrypt('password')
        ]);
        $user1->assignRole('orders importer');

    }
}
