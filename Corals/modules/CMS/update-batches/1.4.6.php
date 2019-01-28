<?php

\Corals\Settings\Models\Setting::whereIn('code', ['home_page_slug', 'blog_page_slug', 'pricing_page_slug'])
    ->update(['category' => 'CMS']);