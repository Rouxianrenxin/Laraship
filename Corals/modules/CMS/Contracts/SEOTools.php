<?php

namespace Corals\Modules\CMS\Contracts;

/**
 * SEOTools.
 *
 * @author `Vinicius Reis`
 */
interface SEOTools
{
    /**
     * @return \Corals\Modules\CMS\Contracts\MetaTags
     */
    public function metatags();

    /**
     * @return \Corals\Modules\CMS\Contracts\OpenGraph
     */
    public function opengraph();

    /**
     * @return \Corals\Modules\CMS\Contracts\TwitterCards
     */
    public function twitter();

    /**
     * Setup title for all seo providers.
     *
     * @param string $title
     *
     * @return \Corals\Modules\CMS\Contracts\SEOTools
     */
    public function setTitle($title);

    /**
     * Setup description for all seo providers.
     *
     * @param string $description
     *
     * @return \Corals\Modules\CMS\Contracts\SEOTools
     */
    public function setDescription($description);

    /**
     * Sets the canonical URL.
     *
     * @param string $url
     *
     * @return \Corals\Modules\CMS\Contracts\SEOTools
     */
    public function setCanonical($url);

    /**
     * Add one or more images urls.
     *
     * @param array|string $urls
     *
     * @return \Corals\Modules\CMS\Contracts\SEOTools
     */
    public function addImages($urls);

    /**
     * Get current title from metatags.
     *
     * @param bool $session
     *
     * @return string
     */
    public function getTitle($session = false);

    /**
     * Generate from all seo providers.
     * 
     * @param bool $minify
     *
     * @return string
     */
    public function generate($minify = false);
}
