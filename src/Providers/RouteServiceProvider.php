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
            $router->get('admin/objects', ['as' => 'admin.objects.index', 'uses' => 'AdminController@index']);
            $router->get('admin/objects/create', ['as' => 'admin.objects.create', 'uses' => 'AdminController@create']);
            $router->get('admin/objects/{object}/edit', ['as' => 'admin.objects.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/objects', ['as' => 'admin.objects.store', 'uses' => 'AdminController@store']);
            $router->put('admin/objects/{object}', ['as' => 'admin.objects.update', 'uses' => 'AdminController@update']);

            /*
             * API routes
             */
            $router->get('api/objects', ['as' => 'api.objects.index', 'uses' => 'ApiController@index']);
            $router->put('api/objects/{object}', ['as' => 'api.objects.update', 'uses' => 'ApiController@update']);
            $router->delete('api/objects/{object}', ['as' => 'api.objects.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
