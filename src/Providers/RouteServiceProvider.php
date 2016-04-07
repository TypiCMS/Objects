<?php

namespace TypiCMS\Modules\Objects\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Objects\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('objects')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.objects', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.objects.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/objects', 'AdminController@index')->name('admin::index-objects');
            $router->get('admin/objects/create', 'AdminController@create')->name('admin::create-object');
            $router->get('admin/objects/{object}/edit', 'AdminController@edit')->name('admin::edit-object');
            $router->post('admin/objects', 'AdminController@store')->name('admin::store-object');
            $router->put('admin/objects/{object}', 'AdminController@update')->name('admin::update-object');

            /*
             * API routes
             */
            $router->get('api/objects', 'ApiController@index')->name('api::index-objects');
            $router->put('api/objects/{object}', 'ApiController@update')->name('api::update-object');
            $router->delete('api/objects/{object}', 'ApiController@destroy')->name('api::destroy-object');
        });
    }
}
