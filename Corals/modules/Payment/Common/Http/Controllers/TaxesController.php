<?php

namespace Corals\Modules\Payment\Common\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Payment\DataTables\TaxesDataTable;
use Corals\Modules\Payment\Common\Http\Requests\TaxRequest;
use Corals\Modules\Payment\Models\Tax;
use Corals\Modules\Payment\Models\TaxClass;

class TaxesController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = route(
            config('payment_common.models.tax.resource_route'),
            ['tax_class' => request()->route('tax_class')]
        );

        $this->title = 'Payment::module.tax.title';
        $this->title_singular = 'Payment::module.tax.title_singular';

        parent::__construct();
    }

    /**
     * @param TaxRequest $request
     * @param TaxClass $tax_class
     * @param TaxesDataTable $dataTable
     * @return mixed
     */
    public function index(TaxRequest $request, TaxClass $tax_class, TaxesDataTable $dataTable)
    {
        $this->setViewSharedData(['title' => trans('Payment::labels.tax.index_title', ['name' => $tax_class->name, 'title' => $this->title])]);

        return $dataTable->setResourceUrl($this->resource_url)->render('Payment::taxes.index', compact('tax_class'));
    }

    /**
     * @param TaxRequest $request
     * @param TaxClass $tax_class
     * @return $this
     */
    public function create(TaxRequest $request, TaxClass $tax_class)
    {
        $tax = new Tax();

        $tax->tax_class_id = $tax_class->id;

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Payment::taxes.create_edit')->with(compact('tax', 'tax_class'));
    }

    /**
     * @param TaxRequest $request
     * @param TaxClass $tax_class
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TaxRequest $request, TaxClass $tax_class)
    {
        try {
            $data = $request->except('link');

            if ($request->has('link')) {
                $data['content'] = $request->link;
            }

            $tax = $tax_class->taxes()->create($data);


            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Tax::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param TaxRequest $request
     * @param TaxClass $tax_class
     * @param Tax $tax
     * @return $this
     */
    public function show(TaxRequest $request, TaxClass $tax_class, Tax $tax)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $tax->name])]);
        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $tax->hashed_id . '/edit']);
        return view('Payment::taxes.show')->with(compact('tax', 'tax_class'));
    }

    /**
     * @param TaxRequest $request
     * @param TaxClass $tax_class
     * @param Tax $tax
     * @return $this
     */
    public function edit(TaxRequest $request, TaxClass $tax_class, Tax $tax)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $tax->name])]);

        return view('Payment::taxes.create_edit')->with(compact('tax', 'tax_class'));
    }

    /**
     * @param TaxRequest $request
     * @param TaxClass $tax_class
     * @param Tax $tax
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TaxRequest $request, TaxClass $tax_class, Tax $tax)
    {
        try {
            $data = $request->except('link');

            if ($request->has('link')) {
                $data['content'] = $request->link;
            }

            $tax->update($data);


            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Tax::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param TaxRequest $request
     * @param TaxClass $tax_class
     * @param Tax $tax
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TaxRequest $request, TaxClass $tax_class, Tax $tax)
    {
        try {
            $tax->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Tax::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}