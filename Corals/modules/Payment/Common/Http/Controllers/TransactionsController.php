<?php

namespace Corals\Modules\Payment\Common\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Payment\DataTables\TransactionsDataTable;
use Corals\Modules\Payment\Http\Requests\TransactionRequest;
use Corals\Modules\Payment\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('payment_common.models.transaction.resource_url');
        $this->corals_middleware_except = [''];
        parent::__construct();

    }


    public function index(Request $request, TransactionsDataTable $dataTable)
    {


        $this->setViewSharedData([
            'title' => trans('Payment::module.transaction.title'),
            'hide_sidebar' => false,
            'hideCreate' => true

        ]);

        return $dataTable->render('Payment::transactions.index');
    }

    /**
     * @param TransactionRequest $request
     * @param Transaction $transaction
     * @return $this
     */
    public function edit(Transaction $transaction)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $transaction->id])]);


        return view('Payment::transactions.create_edit')->with(compact('transaction'));
    }

    /**
     * @param TransactionRequest $request
     * @param Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        try {
            $data = $request->all();
            $transaction->update($data);


            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Transaction::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param TransactionRequest $request
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TransactionRequest $request, Transaction $transaction)
    {
        try {
            $transaction->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Transaction::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}