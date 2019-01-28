<?php

namespace Corals\Foundation\Search;

class TermBuilder
{

    public static function terms($search, $config)
    {
        $wildcards = $config['enable_wildcards'] ?? false;

        $terms = collect(preg_split('/[\s,]+/', $search));

        if ($wildcards === true) {
            $terms->each(function ($part) {
                return $part . '*';
            });
        }
        return $terms;
    }

}
