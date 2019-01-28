<?php

namespace Corals\Modules\Payment\Common\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Foundation\Http\Requests\BulkRequest;
use Corals\Modules\Payment\Models\WebhookCall;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Corals\Modules\Payment\DataTables\WebhookCallsDataTable;

class WebhooksController extends BaseController
{
    public function __construct()
    {
        $this->corals_middleware_except = ['__invoke'];
        parent::__construct();

    }

    public function __invoke(Request $request, $gateway)
    {
        $handler = config('payment_' . strtolower($gateway) . '.webhook_handler');

        if ($handler) {
            $handler::webhookHandler($request);
        }
    }

    public function webhookCalls(Request $request, WebhookCallsDataTable $dataTable)
    {
        if (!user()->hasPermissionTo('Payment::webhook.view')) {
            abort(403);
        }

        $this->setViewSharedData([
            'title' => trans('Payment::module.webhook.title'),
            'hide_sidebar' => false,
            'hideCreate' => true

        ]);

        return $dataTable->render('Payment::webhook_calls');
    }

    /**
     * @param BulkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkAction(BulkRequest $request)
    {
        try {

            $action = $request->input('action');
            $selection = json_decode($request->input('selection'), true);

            $message = [];
            switch ($action) {
                case 'process':
                    foreach ($selection as $selection_id) {
                        $webhook = WebhookCall::findByHash($selection_id);
                        $webhook_request = new Request();
                        $webhook_request->setMethod('POST');
                        $webhook_request->merge(array('throw_exception' => true));

                        $this->process($webhook_request, $webhook);
                    }
                    $message = ['level' => 'success', 'message' => trans('Payment::messages.webhook_processed')];
                    break;
            }


        } catch (\Exception $exception) {
            log_exception($exception, WebhookCall::class, 'bulkAction');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function Process(Request $request, WebhookCall $webhookCall)
    {
        if (!user()->hasPermissionTo('Payment::webhook.view')) {
            abort(403);
        }
        try {
            $webhookCall->process();
            $message = ['level' => 'success', 'message' => trans('Payment::messages.webhook_processed')];

        } catch (\Exception $exception) {
            if ($webhookCall) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'ReProcess');
            if ($request->has('throw_exception')) {

                throw($exception);
            }
            $message = ['level' => 'error', 'message' => $exception->getMessage()];

        }
        return response()->json($message);


    }

}