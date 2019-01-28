<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\DataTables\PagesDataTable;
use Corals\Modules\CMS\Http\Requests\PageRequest;
use Corals\Modules\CMS\Models\Page;

class PagesController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('cms.models.page.resource_url');
        $this->title = 'CMS::module.page.title';
        $this->title_singular = 'CMS::module.page.title_singular';

        parent::__construct();
    }

    /**
     * @param PageRequest $request
     * @param PagesDataTable $dataTable
     * @return mixed
     */
    public function index(PageRequest $request, PagesDataTable $dataTable)
    {
        return $dataTable->render('CMS::pages.index');
    }

    /**
     * @param PageRequest $request
     * @return $this
     */
    public function create(PageRequest $request)
    {
        $page = new Page();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('CMS::pages.create_edit')->with(compact('page'));
    }

    /**
     * @param PageRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PageRequest $request)
    {
        try {
            $data = $request->except('featured_image');

            $data['author_id'] = user()->id;

            $page = Page::create($data);

            if ($request->hasFile('featured_image')) {
                $page->addMedia($request->file('featured_image'))->withCustomProperties(['root' => 'user_' . user()->hashed_id])->toMediaCollection('featured-image');
                $data['featured_image_link'] = null;
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Page::class, 'created');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param PageRequest $request
     * @param Page $page
     * @return $this
     */
    public function show(PageRequest $request, Page $page)
    {
        return redirect('admin-preview/' . $page->slug);
    }

    /**
     * @param PageRequest $request
     * @param Page $page
     * @return $this
     */
    public function design(PageRequest $request, Page $page)
    {
        try {
            \Theme::set(\Settings::get('active_frontend_theme', config('themes.corals_frontend')));
            // Get the theme
            $theme = \Theme::find(\Theme::get());

            return view('CMS::designer.designer')->with(compact('page', 'theme'));
        } catch (\Exception $exception) {
            abort(404);
        }
    }

    /**
     * @param PageRequest $request
     * @param Page $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveDesign(PageRequest $request, Page $page)
    {
        try {
            $page->content = $request->get('content');
            $page->save();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.updated', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Page::class, 'saveDesign');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param PageRequest $request
     * @param Page $page
     * @return $this
     */
    public function edit(PageRequest $request, Page $page)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $page->title])]);

        return view('CMS::pages.create_edit')->with(compact('page'));
    }

    /**
     * @param PageRequest $request
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PageRequest $request, Page $page)
    {
        try {
            $data = $request->all();
            $page->update($data);

            if ($request->has('clear') || $request->hasFile('featured_image')) {
                $page->clearMediaCollection('featured-image');
            }

            if ($request->hasFile('featured_image') && !$request->has('clear')) {
                $page->addMedia($request->file('featured_image'))->withCustomProperties(['root' => 'user_' . user()->hashed_id])->toMediaCollection('featured-image');
                $data['featured_image_link'] = null;
            }

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Page::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param PageRequest $request
     * @param Page $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PageRequest $request, Page $page)
    {
        try {
            $page->clearMediaCollection('featured-image');
            $page->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Page::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}