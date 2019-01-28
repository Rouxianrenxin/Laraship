<?php

namespace Corals\Modules\Advert\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Advert\DataTables\ImpressionsDataTable;
use Corals\Modules\Advert\Http\Requests\ImpressionRequest;
use Corals\Modules\Advert\Models\Impression;
use Illuminate\Http\Request;

class ImpressionsController extends BaseController
{
    protected $excludedRequestParams = [];

    public function __construct()
    {
        $this->corals_middleware_except = ['click'];

        $this->resource_url = config('advert.models.impression.resource_url');

        $this->title = 'Advert::module.impression.title';

        $this->title_singular = 'Advert::module.impression.title_singular';

        $this->setViewSharedData(['hideCreate' => true]);

        parent::__construct();
    }

    /**
     * @param ImpressionRequest $request
     * @param ImpressionsDataTable $dataTable
     * @return mixed
     */
    public function index(ImpressionRequest $request, ImpressionsDataTable $dataTable)
    {
        return $dataTable->render('Advert::impressions.index');
    }

    public function click(Request $request, $impressionSlug)
    {
        $impression = Impression::where('impression_slug', $impressionSlug)->first();

        if (!$impression) {
            abort(404);
        }

        $impression->update(['clicked' => true]);

        $banner = $impression->banner;

        if ($banner && $banner->url) {
            return redirect($banner->url);
        } else {
            return redirect('/');
        }
    }
}