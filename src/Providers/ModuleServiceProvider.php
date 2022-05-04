<?php

namespace TypiCMS\Modules\Videos\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Videos\Composers\SidebarViewComposer;
use TypiCMS\Modules\Videos\Facades\Videocategories;
use TypiCMS\Modules\Videos\Facades\Videos;
use TypiCMS\Modules\Videos\Models\Videocategory;
use TypiCMS\Modules\Videos\Models\Video;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.videos');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

       $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['videos' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(null, 'videocategories');
        $this->loadViewsFrom(null, 'videos');


        AliasLoader::getInstance()->alias('Videocategories', Videocategories::class);
        AliasLoader::getInstance()->alias('Videos', Videos::class);

        // Observers
        Videocategory::observe(new SlugObserver());
        Video::observe(new SlugObserver());



        $this->publishes([
            __DIR__.'/../database/migrations/create_videos_table.php.stub' => getMigrationFileName('create_videos_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/videos'),
        ], 'views');


        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('videos::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('videos');
        });
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Videocategories', Videocategory::class);
        $app->bind('Videos', Video::class);
    }
}
