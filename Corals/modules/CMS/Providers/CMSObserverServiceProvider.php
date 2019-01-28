<?php

namespace Corals\Modules\CMS\Providers;

use Corals\Modules\CMS\Models\Category;
use Corals\Modules\CMS\Models\News;
use Corals\Modules\CMS\Models\Page;
use Corals\Modules\CMS\Models\Post;
use Corals\Modules\CMS\Observers\CategoryObserver;
use Corals\Modules\CMS\Observers\NewsObserver;
use Corals\Modules\CMS\Observers\PageObserver;
use Corals\Modules\CMS\Observers\PostObserver;
use Illuminate\Support\ServiceProvider;

class CMSObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
        Page::observe(PageObserver::class);
        Category::observe(CategoryObserver::class);
        News::observe(NewsObserver::class);
    }
}