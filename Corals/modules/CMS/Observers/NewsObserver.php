<?php
/**
 * Created by PhpStorm.
 * User: iMak
 * Date: 11/19/17
 * Time: 9:17 AM
 */

namespace Corals\Modules\CMS\Observers;

use Corals\Modules\CMS\Models\News;

class NewsObserver
{
    /**
     * @param News $news
     */
    public function created(News $news)
    {
    }
}