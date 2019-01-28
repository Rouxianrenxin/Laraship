<?php

namespace Corals\Modules\CMS\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class BlockPresenter extends FractalPresenter
{

    /**
     * @return BlockTransformer
     */
    public function getTransformer()
    {
        return new BlockTransformer();
    }
}