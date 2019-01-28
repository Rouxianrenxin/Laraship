<?php

namespace Corals\Modules\Advert\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Advert\DataTables\WebsitesDataTable;
use Corals\Modules\Advert\Http\Requests\WebsiteRequest;
use Corals\Modules\Advert\Models\Website;

class WebsitesController extends BaseController
{
    protected $excludedRequestParams = [];

    public function __construct()
    {
        $this->resource_url = config('advert.models.website.resource_url');

        $this->title = 'Advert::module.website.title';
        $this->title_singular = 'Advert::module.website.title_singular';

        parent::__construct();
    }

    /**
     * @param WebsiteRequest $request
     * @param WebsitesDataTable $dataTable
     * @return mixed
     */
    public function index(WebsiteRequest $request, WebsitesDataTable $dataTable)
    {
        return $dataTable->render('Advert::websites.index');
    }

    /**
     * @param WebsiteRequest $request
     * @return $this
     */
    public function create(WebsiteRequest $request)
    {
        $website = new Website();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Advert::websites.create_edit')->with(compact('website'));
    }

    /**
     * @param WebsiteRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(WebsiteRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $website = Website::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Website::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param WebsiteRequest $request
     * @param Website $website
     * @return Website
     */
    public function show(WebsiteRequest $request, Website $website)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $website->name])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $website->hashed_id . '/edit']);

        return view('Advert::websites.show')->with(compact('website'));
    }

    /**
     * @param WebsiteRequest $request
     * @param Website $website
     * @return $this
     */
    public function edit(WebsiteRequest $request, Website $website)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $website->name])]);

        return view('Advert::websites.create_edit')->with(compact('website'));
    }

    /**
     * @param WebsiteRequest $request
     * @param Website $website
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(WebsiteRequest $request, Website $website)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $website->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Website::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param WebsiteRequest $request
     * @param Website $website
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(WebsiteRequest $request, Website $website)
    {
        try {
            $website->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Website::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}