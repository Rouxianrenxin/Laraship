<?php

namespace Corals\Modules\CMS;

use Corals\Modules\CMS\Facades\CMS;
use \Corals\Modules\CMS\Hooks\CMS as CMSHook;
use Corals\Modules\CMS\Facades\OpenGraph;
use Corals\Modules\CMS\Facades\SEOMeta;
use Corals\Modules\CMS\Facades\SEOTools;
use Corals\Modules\CMS\Facades\TwitterCard;
use Corals\Modules\CMS\Models\Category;
use Corals\Modules\CMS\Models\Faq;
use Corals\Modules\CMS\Models\News;
use Corals\Modules\CMS\Models\Page;
use Corals\Modules\CMS\Models\Post;
use Corals\Modules\CMS\Models\Block;
use Corals\Modules\CMS\Providers\CMSAuthServiceProvider;
use Corals\Modules\CMS\Providers\CMSObserverServiceProvider;
use Corals\Modules\CMS\Providers\CMSRouteServiceProvider;
use Corals\Modules\CMS\Providers\SEOToolsServiceProvider;
use Corals\Modules\Utility\Facades\Utility;
use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CMSServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'CMS');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'CMS');

        // Load migrations
//        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        //Register Widgets
        $this->registerWidgets();
        $this->registerCustomFieldsModels();

        \Filters::add_filter('dashboard_content', [CMSHook::class, 'dashboard_content1'], 15);
        \Filters::add_filter('dashboard_content', [CMSHook::class, 'dashboard_content2'], 25);

        $this->registerShortcode();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/cms.php', 'cms');

        $this->app->register(CMSRouteServiceProvider::class);
        $this->app->register(CMSAuthServiceProvider::class);
        $this->app->register(CMSObserverServiceProvider::class);
        $this->app->register(SEOToolsServiceProvider::class);

        //register aliases instead of adding it to config/app.php
        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('CMS', CMS::class);
            $loader->alias('SEOMeta', SEOMeta::class);
            $loader->alias('OpenGraph', OpenGraph::class);
            $loader->alias('Twitter', TwitterCard::class);
            $loader->alias('SEO', SEOTools::class);
        });


        Utility::addToUtilityModules('CMS');
    }

    public function registerWidgets()
    {
        \Shortcode::addWidget('cms', \Corals\Modules\CMS\Widgets\CMSWidget::class);
        \Shortcode::addWidget('page_views', \Corals\Modules\CMS\Widgets\PageViewsWidget::class);
        \Shortcode::addWidget('current_visitors', \Corals\Modules\CMS\Widgets\CurrentVisitorCountWidget::class);
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Post::class);
        Settings::addCustomFieldModel(Page::class);
        Settings::addCustomFieldModel(News::class);
        Settings::addCustomFieldModel(Faq::class);
        Settings::addCustomFieldModel(Category::class);
    }

    public function registerShortcode()
    {
        \Shortcode::add('block', function ($key) {
            $view = 'CMS::blocks.block';

            if ($key == '$block') {
                //Assume Block Object passed
                return "<?php  echo \$__env->make('$view',['block'=>{$key}])->render(); ?>";
            } else {
                $block = Block::where('key', $key)->active()->first();

                view()->share(['block' => $block, 'block_key' => $key]);
            }
            if (view()->exists($view)) {
                return "<?php  echo \$__env->make('$view')->render(); ?>";
            }
        });
    }
}
