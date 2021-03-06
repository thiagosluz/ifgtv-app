<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //criar pagina dashboard
        Page::create([
            'text' => 'Dashboard',
            'url' => 'home',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'order' => 1,
        ]);
        //criar pagina menu
        $pagUser = Page::create([
            'text' => 'Menus',
            'url' => 'admin/pages',
            'icon' => 'fas fa-fw fa-bars',
            'order' => 2,
            'can' => 'pages-list',
        ]);

        //criar pagina Users
        $pagUser = Page::create([
            'text' => 'Users',
            'url' => 'admin/users',
            'icon' => 'fas fa-fw fa-users',
            'order' => 3,
            'can' => 'users-list',
        ]);

        //criar pagina Roles
        $pagRole = Page::create([
            'text' => 'Roles',
            'url' => 'admin/roles',
            'icon' => 'fas fa-fw fa-user-tag',
            'order' => 4,
            'can' => 'roles-list',
        ]);

        //criar pagina Permissions
        $pagPermission = Page::create([
            'text' => 'Permissions',
            'url' => 'admin/permissions',
            'icon' => 'fas fa-fw fa-user-lock',
            'order' => 5,
            'can' => 'permissions-list',
        ]);

        //criar pagina Logs
        $pagLog = Page::create([
            'text' => 'Logs',
            'url' => 'log-viewer',
            'icon' => 'fas fa-fw fa-bug',
            'order' => 6,
            'can' => 'logs-list',
        ]);

        //criar pagina Publicações
        $pagPost = Page::create([
            'text' => 'Publicações',
            'url' => 'publications',
            'icon' => 'fas fa-fw fa-tv',
            'order' => 7,
            'can' => 'publications-list',
        ]);

    }
}
