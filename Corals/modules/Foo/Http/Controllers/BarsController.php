<?php

namespace Corals\Modules\Foo\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Foo\DataTables\BarsDataTable;
use Corals\Modules\Foo\Http\Requests\BarRequest;
use Corals\Modules\Foo\Models\Bar;

class BarsController extends BaseController
{
    protected $excludedRequestParams = [];

    public function __construct()
    {
        $this->resource_url = config('foo.models.bar.resource_url');

        $this->title = 'Foo::module.bar.title';
        $this->title_singular = 'Foo::module.bar.title_singular';

        parent::__construct();
    }

    /**
     * @param BarRequest $request
     * @param BarsDataTable $dataTable
     * @return mixed
     */
    public function index(BarRequest $request, BarsDataTable $dataTable)
    {
        return $dataTable->render('Foo::bars.index');
    }

    /**
     * @param BarRequest $request
     * @return $this
     */
    public function create(BarRequest $request)
    {
        $bar = new Bar();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Foo::bars.create_edit')->with(compact('bar'));
    }

    /**
     * @param BarRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BarRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $bar = Bar::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Bar::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param BarRequest $request
     * @param Bar $bar
     * @return Bar
     */
    public function show(BarRequest $request, Bar $bar)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $bar->getIdentifier()])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $bar->hashed_id . '/edit']);

        return view('Foo::bars.show')->with(compact('bar'));
    }

    /**
     * @param BarRequest $request
     * @param Bar $bar
     * @return $this
     */
    public function edit(BarRequest $request, Bar $bar)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $bar->getIdentifier()])]);

        return view('Foo::bars.create_edit')->with(compact('bar'));
    }

    /**
     * @param BarRequest $request
     * @param Bar $bar
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(BarRequest $request, Bar $bar)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $bar->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Bar::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param BarRequest $request
     * @param Bar $bar
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BarRequest $request, Bar $bar)
    {
        try {
            $bar->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Bar::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}