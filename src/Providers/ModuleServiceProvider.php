<?php

namespace TypiCMS\Modules\Objects\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Objects\Composers\SidebarViewComposer;
use TypiCMS\Modules\Objects\Facades\Objects;
use TypiCMS\Modules\Objects\Models\Object;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.objects');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['objects' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'objects');

        $this->publishes([
            __DIR__.'/../database/migrations/create_objects_table.php.stub' => getMigrationFileName('create_objects_table'),
        ], 'migrations');

        AliasLoader::getInstance()->alias('Objects', Objects::class);

        // Observers
        Object::observe(new SlugObserver());

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('objects::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('objects');
        });
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Objects', Object::class);
    }
}
