<?php

namespace TypiCMS\Modules\Objects\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Objects\Http\Controllers\AdminController;
use TypiCMS\Modules\Objects\Http\Controllers\ApiController;
use TypiCMS\Modules\Objects\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
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
                            $router->get($uri, $options + ['uses' => [PublicController::class, 'index']])->name($lang.'::index-objects');
                            $router->get($uri.'/{slug}', $options + ['uses' => [PublicController::class, 'show']])->name($lang.'::object');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('objects', [AdminController::class, 'index'])->name('admin::index-objects')->middleware('can:read objects');
                $router->get('objects/create', [AdminController::class, 'create'])->name('admin::create-object')->middleware('can:create objects');
                $router->get('objects/{object}/edit', [AdminController::class, 'edit'])->name('admin::edit-object')->middleware('can:update objects');
                $router->post('objects', [AdminController::class, 'store'])->name('admin::store-object')->middleware('can:create objects');
                $router->put('objects/{object}', [AdminController::class, 'update'])->name('admin::update-object')->middleware('can:update objects');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('objects', [ApiController::class, 'index'])->middleware('can:read objects');
                    $router->patch('objects/{object}', [ApiController::class, 'updatePartial'])->middleware('can:update objects');
                    $router->delete('objects/{object}', [ApiController::class, 'destroy'])->middleware('can:delete objects');
                });
            });
        });
    }
}
