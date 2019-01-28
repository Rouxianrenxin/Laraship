<?php

namespace Corals\Modules\CMS\Classes;

use Corals\Modules\CMS\Models\Category;
use Corals\Modules\CMS\Models\Content;
use Corals\Modules\CMS\Models\Post;
use Corals\Modules\Utility\Models\Tag\Tag;
use Spatie\MediaLibrary\Media;
use Corals\Modules\CMS\Models\News;

class CMS
{
    /**
     * CMS constructor.
     */
    function __construct()
    {
    }

    /**
     * @param bool $objects
     * @param null $status
     * @param bool $internalState
     * @return mixed
     */
    public function getCategoriesList($objects = false, $status = null, $internalState = null, $belongsTo = 'post')
    {
        $categories = Category::query()->where('belongs_to', '=', $belongsTo);

        if (!is_null($internalState)) {
            $categories = $categories->whereHas('posts', function ($query) use ($internalState) {
                $query->internal($internalState);
            });
        }

        $not_available_categories = $this->getNotAvailableCategories();
        if ($not_available_categories) {
            $categories->whereNotIn('id', $not_available_categories);
        }
        if ($status) {
            $categories = $categories->where('status', $status);
        }
        if ($objects) {
            $categories = $categories->get();
        } else {
            $categories = $categories->pluck('name', 'id');
        }

        if ($categories->isEmpty()) {
            return [];
        } else {
            return $categories;
        }
    }

    /**
     * @param $category
     * @param bool $internalState
     * @return mixed
     */
    public function getCategoryPostsCount($category, $internalState = false)
    {
        $posts = $category->posts()->internal($internalState)->published();

        if (!user()) {
            $posts = $posts->public();
        }

        return $posts->count();
    }

    /**
     * @param bool $objects
     * @param null $status
     * @param bool $internalState
     * @return mixed
     */
    public function getTagsList($objects = false, $status = null)
    {
        $tags = Tag::query()->withModule('CMS');

        if ($status) {
            $tags = $tags->where('status', $status);
        }

        if ($objects) {
            $tags = $tags->get();
        } else {
            $tags = $tags->pluck('name', 'id');
        }

        if ($tags->isEmpty()) {
            return [];
        } else {
            return $tags;
        }
    }

    /**
     * @param Content $content
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function getContentFeaturedImage(Content $content)
    {
        if (!$content) {
            return null;
        }

        $media = Media::where('collection_name', 'featured-image')->where('model_id', $content->id)->first();

        if ($media) {
            return $media->getFullUrl();
        } elseif ($content->featured_image_link) {
            return url($content->featured_image_link);
        } else {
            return null;
        }
    }

    public function getLatestPosts($limit = 2, $internalState = false)
    {
        $posts = Post::whereHas('categories', function ($categories) {
            $categories->where('status', 'active');
        })->internal($internalState);

        $posts = $posts->published();

        if (!user()) {
            $posts = $posts->public();
        }

        $posts = $posts->orderBy('published_at', 'desc')->take($limit)->get();

        return $posts;
    }

    public function getFrontendThemeTemplates()
    {
        $frontend_theme = \Settings::get('active_frontend_theme');
        $theme_views_path = \Theme::find($frontend_theme)->viewsPath;
        $templates = [];
        foreach (glob(themes_path($theme_views_path . '/templates/*.php')) as $template) {
            $template_key = basename(str_replace('.blade.php', '', $template));
            $templates[$template_key] = ucfirst($template_key);
        }
        return $templates;

    }

    public function getNotAvailableCategories()
    {
        if (user() && user()->hasPermissionTo('Administrations::admin.cms')) {
            return [];
        }
        $not_available_categories = [];
        if (\Modules::isModuleActive('corals-subscriptions')) {

            $categories = Category::all();
            $not_available_categories = [];
            foreach ($categories as $category) {
                $subscription_plans = $category->subscribable_plans;
                if ($subscription_plans) {
                    foreach ($subscription_plans as $subscription_plan) {
                        if (!user() || !user()->subscriptions->where('plan_id', $subscription_plan->id)->count()) {
                            $not_available_categories [] = $category->id;

                        }
                    }
                }
            }
        }
        return $not_available_categories;
    }

    public function getLatestNews($limit = 3)
    {

        $news = News::published();
        $news = $news->orderBy('published_at', 'desc')->take($limit)->get();

        return $news;
    }

    public function getCategoriesBelongsTo() {
        $belongs_to = [
            'post' => trans('CMS::attributes.category.post'),
            'faq' => trans('CMS::attributes.category.faq'),
        ];

        return $belongs_to;
    }
}