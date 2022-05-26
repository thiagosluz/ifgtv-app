<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role3 = Role::create(['name' => 'Super-Admin']);
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole($role3);


    }
}
