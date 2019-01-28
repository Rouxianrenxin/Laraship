<?php

namespace Corals\Settings\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class SettingPresenter extends FractalPresenter
{

    /**
     * @return SettingTransformer
     */
    public function getTransformer()
    {
        return new SettingTransformer();
    }
}