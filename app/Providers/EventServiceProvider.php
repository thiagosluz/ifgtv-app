<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Publication;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...

//            $event->menu->add([
//                'text' => 'Blog',
//                'url' => 'admin/blog',
//                'icon' => 'fas fa-fw fa-circle',
//                'label'       => Publication::publicado()->exibir()->count(),
//                'label_color' => 'danger',
//            ]);


            $items = Page::all()->sortBy('order')->map(function (Page $page) {
                return [
                    'text' => $page['text'],
                    'url' => $page['url'],
                    'icon' => $page['icon'],
                    'active' => [$page['url'] .'*', 'regex:@^content/[0-9]+$@'],
                    'can'  => $page['can'],
                ];
            });

            $event->menu->add(...$items);

        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
