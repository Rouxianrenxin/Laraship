<?php

namespace Corals\Modules\CMS\Traits;

use Corals\Modules\CMS\Contracts\SEOFriendly;

trait SEOTools
{
    /**
     * @return \Corals\Modules\CMS\Contracts\SEOTools
     */
    protected function seo()
    {
        return app('seotools');
    }

    /**
     * @param SEOFriendly $friendly
     *
     * @return \Corals\Modules\CMS\Contracts\SEOTools
     */
    protected function loadSEO(SEOFriendly $friendly)
    {
        $SEO = $this->seo();

        $friendly->loadSEO($SEO);

        return $SEO;
    }

    protected function setSEO($item)
    {
        $this->seo()->setTitle($item->title . ' | ' . \Settings::get('site_name', 'Corals'));
        $this->seo()->setDescription($item->meta_description);
        $this->seo()->opengraph()->setUrl($item->url);
        $this->seo()->opengraph()->addProperty('type', $item->type);

        if (property_exists($item, 'image')) {
            $this->seo()->opengraph()->addProperty('image', $item->image);
        }

        if (property_exists($item, 'meta_keywords')) {
            $this->seo()->setKeywords($item->meta_keywords);
        }
    }
}
