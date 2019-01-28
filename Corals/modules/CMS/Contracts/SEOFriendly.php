<?php

namespace Corals\Modules\CMS\Contracts;

interface SEOFriendly
{
    /**
     * Performs SEO settings.
     *
     * @param SEOTools $SEOTools
     */
    public function loadSEO(SEOTools $SEOTools);
}
