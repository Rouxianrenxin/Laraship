<?php

namespace Corals\Modules\Newsletter\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Newsletter\DataTables\EmailLoggerDataTable;
use Corals\Modules\Newsletter\Facades\Newsletter;
use Corals\Modules\Newsletter\Http\Requests\EmailRequest;
use Corals\Modules\Newsletter\Mail\NewsletterEmail;
use Corals\Modules\Newsletter\Models\EmailLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailLoggersController extends BaseController
{
    protected $excludedRequestParams = ['submit_type'];

    protected $corals_middleware_except = ['mailTracker'];

    public function __construct()
    {
        $this->resource_url = config('newsletter.models.email_logger.resource_url');

        $this->title = 'Newsletter::module.email_logger.title';
        $this->title_singular = 'Newsletter::module.email_logger.title_singular';

        $this->setViewSharedData(['hideCreate' => true]);

        parent::__construct();
    }

    /**
     * @param EmailRequest $request
     * @param EmailLoggerDataTable $dataTable
     * @return mixed
     */
    public function index(EmailRequest $request, EmailLoggerDataTable $dataTable)
    {
        return $dataTable->render('Newsletter::email_loggers.index');
    }


    /**
     * @param EmailRequest $request
     * @param EmailLogger $emailLogger
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(EmailRequest $request, EmailLogger $emailLogger)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $emailLogger->email->subject])]);

        return view('Newsletter::email_loggers.show')->with(compact('emailLogger'));
    }

    /**
     * @param EmailRequest $request
     * @param EmailLogger $emailLogger
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EmailRequest $request, EmailLogger $emailLogger)
    {
        try {
            $emailLogger->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, EmailLogger::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function mailTracker(Request $request, $api_call_id)
    {
        $emailLog = EmailLogger::query()
            ->where('api_call_id', '=', $api_call_id)
            ->first();

        if ($emailLog) {
            $details = Newsletter::getVisitorDetails();
            $details['ip'] = $request->getClientIp();
            $details['status'] = 'opened';
            $details['updated_at'] = $request->getUserInfo();
            $emailLog->update($details);
        }
    }

    public function sendEmail(Request $request, EmailLogger $emailLogger)
    {
        try {
            $email = $emailLogger->email;

            Newsletter::sendEmail($email, $emailLogger);

            $message = ['level' => 'success', 'message' => trans('Newsletter::messages.success.email_sent')];
        } catch (\Exception $exception) {
            log_exception($exception, EmailLogger::class, 'sendEmail');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}