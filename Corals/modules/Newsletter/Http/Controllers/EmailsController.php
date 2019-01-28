<?php

namespace Corals\Modules\Newsletter\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Newsletter\DataTables\EmailDataTable;
use Corals\Modules\Newsletter\Facades\Newsletter;
use Corals\Modules\Newsletter\Http\Requests\EmailRequest;
use Corals\Modules\Newsletter\Models\Email;
use Corals\Modules\Newsletter\Models\Subscriber;
use Illuminate\Http\Request;

class EmailsController extends BaseController
{
    protected $excludedRequestParams = ['submit_type'];

    protected $corals_middleware_except = ['mailTracker'];

    public function __construct()
    {
        $this->resource_url = config('newsletter.models.email.resource_url');

        $this->title = 'Newsletter::module.email.title';
        $this->title_singular = 'Newsletter::module.email.title_singular';

        parent::__construct();
    }

    /**
     * @param EmailRequest $request
     * @param EmailDataTable $dataTable
     * @return mixed
     */
    public function index(EmailRequest $request, EmailDataTable $dataTable)
    {
        return $dataTable->render('Newsletter::emails.index');
    }


    /**
     * @param EmailRequest $request
     * @return $this
     */
    public function create(EmailRequest $request)
    {
        $email = new Email();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Newsletter::emails.create_edit')->with(compact('email'));
    }


    /**
     * @param EmailRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EmailRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $email = Email::create($data);

            $this->setEmailLoggers($request, $email);

            if ($request->get('submit_type') == 'send') {
                Newsletter::sendEmail($email);

                $email->update(['status' => 'sent']);
            } else if ($request->get('submit_type') == 'draft') {
                $email->update(['status' => 'draft']);
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Email::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    protected function setEmailLoggers($request, $email)
    {
        $mailLists = $request->get('mail_lists', []);

        $subscribers = $request->get('subscribers', []);

        $subscribers = Subscriber::query()
            ->whereHas('mailLists', function ($query) use ($mailLists) {
                $query
                    ->whereIn('newsletter_mail_lists.id', $mailLists);
            })
            ->orWhereIn('newsletter_subscribers.id', $subscribers)
            ->get();

        $emailLoggers = [];

        foreach ($subscribers as $subscriber) {
            $api_call_id = uniqid();

            $emailLoggers[$subscriber->id] = [
                'api_call_id' => $api_call_id
            ];
        }

        $email->subscribers()->sync($emailLoggers);
    }


    /**
     * @param EmailRequest $request
     * @param Email $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(EmailRequest $request, Email $email)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $email->subject])]);

        return view('Newsletter::emails.create_edit')->with(compact('email'));
    }

    /**
     * @param EmailRequest $request
     * @param Email $email
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(EmailRequest $request, Email $email)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $data['subscribers'] = $data['subscribers'] ?? [];

            $data['mail_lists'] = $data['mail_lists'] ?? [];

            $this->setEmailLoggers($request, $email);

            $email->update($data);

            $data = [];

            if ($request->get('submit_type') == 'send') {
                Newsletter::sendEmail($email);
                $data['status'] = 'sent';
            } else if ($request->get('submit_type') == 'draft') {
                $data['status'] = 'draft';
            }

            $email->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Email::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    public function show(EmailRequest $request, Email $email)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $email->subject])]);

        return view('Newsletter::emails.show')->with(compact('email'));
    }

    public function destroy(EmailRequest $request, Email $email)
    {
        try {
            $email->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Email::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function sendEmail(Request $request, Email $email)
    {
        try {
            Newsletter::sendEmail($email);

            $message = ['level' => 'success', 'message' => trans('Newsletter::messages.success.email_sent')];
        } catch (\Exception $exception) {
            log_exception($exception, Email::class, 'sendEmail');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}