<?php

namespace Corals\Modules\Directory\Http\Controllers;


use Corals\Foundation\Http\Controllers\PublicBaseController;
use Corals\Modules\CMS\Traits\SEOTools;

class DashboardController extends PublicBaseController
{
    use SEOTools;
    public function __construct()
    {
        $this->title = 'Directory::module.dashboard.title';

        $this->title_singular = 'Directory::module.dashboard.title_singular';

        parent::__construct();
    }

    public function index()
    {
        $item = [
            'title' => 'Dashboard',
            'meta_description' => 'Directory Listing',
            'url' => url('directory/user/dashboard'),
            'type' => 'listing',
            'image' => \Settings::get('site_logo'),
            'meta_keywords' => 'directory,listings,dashboard'
        ];

        $this->setSEO((object)$item);

        return view('views.dashboard');
    }

}