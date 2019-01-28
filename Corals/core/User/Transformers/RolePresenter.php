<?php

namespace Corals\User\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class RolePresenter extends FractalPresenter
{

    /**
     * @return RoleTransformer
     */
    public function getTransformer()
    {
        return new RoleTransformer();
    }
}