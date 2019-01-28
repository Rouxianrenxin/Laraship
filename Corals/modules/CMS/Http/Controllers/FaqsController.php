<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\DataTables\FaqsDataTable;
use Corals\Modules\CMS\Http\Requests\FaqRequest;
use Corals\Modules\CMS\Models\Faq;

class FaqsController extends BaseController
{

    public function __construct()
    {
        $this->resource_url = config('cms.models.faq.resource_url');
        $this->title = 'CMS::module.faq.title';
        $this->title_singular = 'CMS::module.faq.title_singular';

        parent::__construct();
    }

    /**
     * @param FaqRequest $request
     * @param FaqsDataTable $dataTable
     * @return mixed
     */
    public function index(FaqRequest $request, FaqsDataTable $dataTable)
    {
        return $dataTable->render('CMS::faqs.index');
    }

    /**
     * @param FaqRequest $request
     * @return $this
     */
    public function create(FaqRequest $request)
    {
        $faq = new Faq();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('CMS::faqs.create_edit')->with(compact('faq'));
    }

    /**
     * @param FaqRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FaqRequest $request)
    {
        try {
            $data = $request->all();

            $data['author_id'] = user()->id;

            $faqs = Faq::create($data);

            $faqs->categories()->sync($data['categories']);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Faq::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param FaqRequest $request
     * @param Faq $faq
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(FaqRequest $request, Faq $faq)
    {
        return redirect('admin-preview/' . $faq->slug);
    }

    /**
     * @param FaqRequest $request
     * @param Faq $faq
     * @return $this
     */
    public function edit(FaqRequest $request, Faq $faq)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $faq->title])]);

        return view('CMS::faqs.create_edit')->with(compact('faq'));
    }

    /**
     * @param FaqRequest $request
     * @param Faq $faq
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        try {
            $data = $request->all();

            $faq->update($data);

            $faq->categories()->sync($data['categories']);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Faq::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param FaqRequest $request
     * @param Faq $faq
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FaqRequest $request, Faq $faq)
    {
        try {
            $faq->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Faq::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
