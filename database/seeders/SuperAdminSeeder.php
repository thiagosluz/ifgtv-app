<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role1 = Role::create(['name' => 'Super-Admin']);

        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@email.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole($role1);


        // create permissions
        //pages
        $pagelist = Permission::create(['name' => 'pages-list']);
        $pagecreate = Permission::create(['name' => 'pages-create']);
        $pageedit = Permission::create(['name' => 'pages-edit']);
        $pagedelete = Permission::create(['name' => 'pages-delete']);

        //users
        $users_list = Permission::create(['name' => 'users-list']);
        $users_create = Permission::create(['name' => 'users-create']);
        $users_edit = Permission::create(['name' => 'users-edit']);
        $users_delete = Permission::create(['name' => 'users-delete']);

        //roles
        $roles_list = Permission::create(['name' => 'roles-list']);
        $roles_create = Permission::create(['name' => 'roles-create']);
        $roles_edit = Permission::create(['name' => 'roles-edit']);
        $roles_delete = Permission::create(['name' => 'roles-delete']);

        //permissions
        $permissions_list = Permission::create(['name' => 'permissions-list']);
        $permissions_create = Permission::create(['name' => 'permissions-create']);
        $permissions_edit = Permission::create(['name' => 'permissions-edit']);
        $permissions_delete = Permission::create(['name' => 'permissions-delete']);

        //logs
        $logs_list = Permission::create(['name' => 'logs-list']);

        //publications
        $publications_list = Permission::create(['name' => 'publications-list']);
        $publications_create = Permission::create(['name' => 'publications-create']);
        $publications_edit = Permission::create(['name' => 'publications-edit']);
        $publications_delete = Permission::create(['name' => 'publications-delete']);
        $publications_previa = Permission::create(['name' => 'publications-previa']);
        $publications_publicar = Permission::create(['name' => 'publications-publicar']);
        $publications_teste = Permission::create(['name' => 'publications-teste']);
        $publications_moderador = Permission::create(['name' => 'publications-moderador']);

        //birthdays
        $birthdays_list = Permission::create(['name' => 'birthdays-list']);
        $birthdays_create = Permission::create(['name' => 'birthdays-create']);
        $birthdays_edit = Permission::create(['name' => 'birthdays-edit']);
        $birthdays_delete = Permission::create(['name' => 'birthdays-delete']);

        //config
        $config_list = Permission::create(['name' => 'config-list']);

        //backup
        $backup_list = Permission::create(['name' => 'backup-list']);



        // create roles and assign created permissions
        //admin
        $role2 = Role::create(['name' => 'admin'])
            ->givePermissionTo([
                $users_list,
                //$users_create,
                $users_edit,
                $users_delete,
                $logs_list,
                $publications_list,
                $publications_create,
                $publications_edit,
                $publications_delete,
                $publications_previa,
                $publications_publicar,
                $publications_teste,
                $publications_moderador,
                $birthdays_list,
                $birthdays_create,
                $birthdays_edit,
                $birthdays_delete,
                $config_list,
              ]);

        $user2 = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('12345678'),
        ]);

        $user2->assignRole($role2);


//        //moderador
        $role3 = Role::create(['name' => 'moderador'])
            ->givePermissionTo([
                $publications_list,
                $publications_create,
                $publications_edit,
                $publications_delete,
                $publications_previa,
                $publications_publicar,
                $publications_teste,
                $publications_moderador,
                $birthdays_list,
                $birthdays_create,
                $birthdays_edit,
                $birthdays_delete,
            ]);

        $user3 = User::factory()->create([
            'name' => 'moderador',
            'email' => 'moderador@email.com',
            'password' => bcrypt('12345678'),
        ]);

        $user3->assignRole($role3);

//        //user
        $role4 = Role::create(['name' => 'usuario'])
            ->givePermissionTo([
                $publications_list,
                $publications_create,
                $publications_edit,
                $publications_delete,
                $publications_previa,
            ]);

        $user4 = User::factory()->create([
            'name' => 'usuario',
            'email' => 'usuario@email.com',
            'password' => bcrypt('12345678'),
        ]);

        $user4->assignRole($role4);

    }
}
