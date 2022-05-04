<?php

namespace TypiCMS\Modules\Videos\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Videos\Http\Controllers\Category\AdminController;
use TypiCMS\Modules\Videos\Http\Controllers\Category\ApiController;
use TypiCMS\Modules\Videos\Http\Controllers\PublicController;
use TypiCMS\Modules\Videos\Http\Controllers\Item\AdminController as ItemAdminController;
use TypiCMS\Modules\Videos\Http\Controllers\Item\ApiController as ItemApiController;


class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('videos')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-videos');
                        $router->get('{slug}', [PublicController::class, 'category'])->name('video-category');
                        $router->get('{categorySlug}/{slug}', [PublicController::class, 'show'])->name('video-show');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('videocategories', [AdminController::class, 'index'])->name('index-videocategories')->middleware('can:read videocategories');
            $router->get('videocategories/export', [AdminController::class, 'export'])->name('admin::export-videocategories')->middleware('can:read videocategories');
            $router->get('videocategories/create', [AdminController::class, 'create'])->name('create-videocategory')->middleware('can:create videocategories');
            $router->get('videocategories/{videocategory}/edit', [AdminController::class, 'edit'])->name('edit-videocategory')->middleware('can:read videocategories');
            $router->post('videocategories', [AdminController::class, 'store'])->name('store-videocategory')->middleware('can:create videocategories');
            $router->put('videocategories/{videocategory}', [AdminController::class, 'update'])->name('update-videocategory')->middleware('can:update videocategories');

            $router->get('videos', [ItemAdminController::class, 'index'])->name('index-videos')->middleware('can:read videos');
            $router->get('videos/export', [ItemAdminController::class, 'export'])->name('admin::export-videos')->middleware('can:read videos');
            $router->get('videos/create', [ItemAdminController::class, 'create'])->name('create-video')->middleware('can:create videos');
            $router->get('videos/{item}/edit', [ItemAdminController::class, 'edit'])->name('edit-video')->middleware('can:read videos');
            $router->post('videos', [ItemAdminController::class, 'store'])->name('store-video')->middleware('can:create videos');
            $router->put('videos/{item}', [ItemAdminController::class, 'update'])->name('update-video')->middleware('can:update videos');

        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('videocategories', [ApiController::class, 'index'])->middleware('can:read videocategories');
            $router->patch('videocategories/{videocategory}', [ApiController::class, 'updatePartial'])->middleware('can:update videocategories');
            $router->delete('videocategories/{videocategory}', [ApiController::class, 'destroy'])->middleware('can:delete videocategories');

            $router->get('videos', [ItemApiController::class, 'index'])->middleware('can:read videos');
            $router->patch('videos/{item}', [ItemApiController::class, 'updatePartial'])->middleware('can:update videos');
            $router->delete('videos/{item}', [ItemApiController::class, 'destroy'])->middleware('can:delete videos');

        });
    }
}
