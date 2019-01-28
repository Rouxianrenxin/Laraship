<?php

namespace Corals\Menu\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class MenuPresenter extends FractalPresenter
{

    /**
     * @return MenuTransformer
     */
    public function getTransformer()
    {
        return new MenuTransformer();
    }
}