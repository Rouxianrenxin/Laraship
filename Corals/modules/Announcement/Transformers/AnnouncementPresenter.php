<?php

namespace Corals\Modules\Announcement\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class AnnouncementPresenter extends FractalPresenter
{

    /**
     * @return AnnouncementTransformer
     */
    public function getTransformer()
    {
        return new AnnouncementTransformer();
    }
}