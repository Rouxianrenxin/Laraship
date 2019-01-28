<?php

namespace Corals\Settings\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class CustomFieldSettingPresenter extends FractalPresenter
{

    /**
     * @return CustomFieldSettingTransformer
     */
    public function getTransformer()
    {
        return new CustomFieldSettingTransformer();
    }
}