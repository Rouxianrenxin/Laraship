<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\Traits\CMSControllerFunctions;

class CMSInternalController extends BaseController
{
    public $view_prefix = '';
    public $internalState = true;

    use CMSControllerFunctions;

    public function __construct()
    {
        $this->view_prefix = 'CMS::cms_internal';

        $this->resetContentQuery();

        parent::__construct();
    }


}