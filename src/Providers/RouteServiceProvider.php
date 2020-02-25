<?php

namespace TypiCMS\Modules\Objects\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
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
     * @return null
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {
            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('objects')) {
                $router->middleware('public')->group(function (Router $router) use ($page) {
                    $options = $page->private ? ['middleware' => 'auth'] : [];
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-objects');
                            $router->get($uri.'/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::object');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('objects', 'AdminController@index')->name('admin::index-objects')->middleware('can:see-all-objects');
                $router->get('objects/create', 'AdminController@create')->name('admin::create-object')->middleware('can:create-object');
                $router->get('objects/{object}/edit', 'AdminController@edit')->name('admin::edit-object')->middleware('can:update-object');
                $router->post('objects', 'AdminController@store')->name('admin::store-object')->middleware('can:create-object');
                $router->put('objects/{object}', 'AdminController@update')->name('admin::update-object')->middleware('can:update-object');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('objects', 'ApiController@index')->middleware('can:see-all-objects');
                    $router->patch('objects/{object}', 'ApiController@updatePartial')->middleware('can:update-object');
                    $router->delete('objects/{object}', 'ApiController@destroy')->middleware('can:delete-object');

                    $router->get('objects/{object}/files', 'ApiController@files')->middleware('can:update-object');
                    $router->post('objects/{object}/files', 'ApiController@attachFiles')->middleware('can:update-object');
                    $router->delete('objects/{object}/files/{file}', 'ApiController@detachFile')->middleware('can:update-object');
                });
            });
        });
    }
}
