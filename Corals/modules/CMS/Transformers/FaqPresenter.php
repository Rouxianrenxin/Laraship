<?php
namespace Corals\Modules\CMS\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class FaqPresenter extends FractalPresenter
{

    /**
     * @return FaqPresenter
     */
    public function getTransformer()
    {
        return new FaqTransformer();
    }
}
