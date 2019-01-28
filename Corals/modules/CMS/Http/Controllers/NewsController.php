<?php
/**
 * Created by PhpStorm.
 * User: iMak
 * Date: 11/19/17
 * Time: 9:29 AM
 */

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\DataTables\NewsDataTable;
use Corals\Modules\CMS\Http\Requests\NewsRequest;
use Corals\Modules\CMS\Models\News;

class NewsController extends BaseController
{

    public function __construct()
    {
        $this->resource_url = config('cms.models.news.resource_url');
        $this->title = 'CMS::module.news.title';
        $this->title_singular = 'CMS::module.news.title_singular';

        parent::__construct();
    }

    /**
     * @param NewsRequest $request
     * @param NewsDataTable $dataTable
     * @return mixed
     */
    public function index(NewsRequest $request, NewsDataTable $dataTable)
    {
        return $dataTable->render('CMS::news.index');
    }

    /**
     * @param NewsRequest $request
     * @return $this
     */
    public function create(NewsRequest $request)
    {
        $news = new News();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('CMS::news.create_edit')->with(compact('news'));
    }

    /**
     * @param NewsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(NewsRequest $request)
    {
        try {
            $data = $request->except('featured_image');

            $news = News::create($data);

            if ($request->hasFile('featured_image')) {
                $news->addMedia($request->file('featured_image'))
                    ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
                    ->toMediaCollection('featured-image');
                $data['featured_image_link'] = null;
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, News::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param NewsRequest $request
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(NewsRequest $request, News $news)
    {
        return redirect('admin-preview/' . $news->slug);
    }

    /**
     * @param NewsRequest $request
     * @param News $news
     * @return $this
     */
    public function edit(NewsRequest $request, News $news)
    {
        $this->setViewSharedData(['title_singular' =>trans('Corals::labels.update_title', ['title' => $news->title])]);

        return view('CMS::news.create_edit')->with(compact('news'));
    }

    /**
     * @param NewsRequest $request
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(NewsRequest $request, News $news)
    {
        try {
            $data = $request->all();

            $news->update($data);

            if ($request->has('clear') || $request->hasFile('featured_image')) {
                $news->clearMediaCollection('featured-image');
            }

            if ($request->hasFile('featured_image') && !$request->has('clear')) {
                $news->addMedia($request->file('featured_image'))
                    ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
                    ->toMediaCollection('featured-image');
                $data['featured_image_link'] = null;
            }

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, News::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param NewsRequest $request
     * @param News $news
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(NewsRequest $request, News $news)
    {
        try {
            $news->clearMediaCollection('featured-image');
            $news->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, News::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}