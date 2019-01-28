<?php

namespace Corals\Modules\Payment\Common\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Payment\DataTables\TaxClassesDataTable;
use Corals\Modules\Payment\Common\Http\Requests\TaxClassRequest;
use Corals\Modules\Payment\Models\TaxClass;
use Corals\Modules\Payment\Payment;

class TaxClassesController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('payment_common.models.tax_class.resource_url');
        $this->title = 'Payment::module.tax_class.title';
        $this->title_singular = 'Payment::module.tax_class.title_singular';

        parent::__construct();
    }

    /**
     * @param TaxClassRequest $request
     * @param TaxClassesDataTable $dataTable
     * @return mixed
     */
    public function index(TaxClassRequest $request, TaxClassesDataTable $dataTable)
    {
        return $dataTable->render('Payment::tax_classes.index');
    }

    /**
     * @param TaxClassRequest $request
     * @return $this
     */
    public function create(TaxClassRequest $request)
    {
        $tax_class = new TaxClass();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);


        return view('Payment::tax_classes.create_edit')->with(compact('tax_class', 'options'));
    }

    /**
     * @param TaxClassRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TaxClassRequest $request)
    {
        try {
            $data = $request->all();


            TaxClass::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, TaxClass::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param TaxClassRequest $request
     * @param TaxClass $tax_class
     * @return TaxClass
     */
    public function show(TaxClassRequest $request, TaxClass $tax_class)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $tax_class->name])]);
        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $tax_class->hashed_id . '/edit']);
        return view('Payment::tax_classes.show')->with(compact('tax_class'));
    }

    /**
     * @param TaxClassRequest $request
     * @param TaxClass $tax_class
     * @return $this
     */
    public function edit(TaxClassRequest $request, TaxClass $tax_class)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $tax_class->name])]);


        return view('Payment::tax_classes.create_edit')->with(compact('tax_class'));
    }

    /**
     * @param TaxClassRequest $request
     * @param TaxClass $tax_class
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TaxClassRequest $request, TaxClass $tax_class)
    {
        try {
            $data = $request->all();
            $tax_class->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, TaxClass::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param TaxClassRequest $request
     * @param TaxClass $tax_class
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TaxClassRequest $request, TaxClass $tax_class)
    {
        try {
            $tax_class->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Payment::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}