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
    public function map(): void
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('objects')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-objects');
                        $router->get('{slug}', [PublicController::class, 'show'])->name('object');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('objects', [AdminController::class, 'index'])->name('index-objects')->middleware('can:read objects');
            $router->get('objects/export', [AdminController::class, 'export'])->name('export-objects')->middleware('can:read objects');
            $router->get('objects/create', [AdminController::class, 'create'])->name('create-object')->middleware('can:create objects');
            $router->get('objects/{object}/edit', [AdminController::class, 'edit'])->name('edit-object')->middleware('can:read objects');
            $router->post('objects', [AdminController::class, 'store'])->name('store-object')->middleware('can:create objects');
            $router->put('objects/{object}', [AdminController::class, 'update'])->name('update-object')->middleware('can:update objects');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('objects', [ApiController::class, 'index'])->middleware('can:read objects');
            $router->patch('objects/{object}', [ApiController::class, 'updatePartial'])->middleware('can:update objects');
            $router->delete('objects/{object}', [ApiController::class, 'destroy'])->middleware('can:delete objects');
        });
    }
}
