<?php

namespace Corals\Modules\Newsletter\Http\Controllers;

use Carbon\Carbon;
use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Newsletter\DataTables\SubscriberDataTable;
use Corals\Modules\Newsletter\DataTables\SubscriberMailListDataTable;
use Corals\Modules\Newsletter\Http\Requests\SubscriberImportRequest;
use Corals\Modules\Newsletter\Http\Requests\SubscriberRequest;
use Corals\Modules\Newsletter\Models\MailList;
use Corals\Modules\Newsletter\Models\Subscriber;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SubscribersController extends BaseController
{
    protected $excludedRequestParams = ['mail_lists'];

    public function __construct()
    {
        $this->resource_url = config('newsletter.models.subscriber.resource_url');

        $this->title = 'Newsletter::module.subscriber.title';
        $this->title_singular = 'Newsletter::module.subscriber.title_singular';

        parent::__construct();
    }

    /**
     * @param SubscriberRequest $request
     * @param SubscriberDataTable $dataTable
     * @return mixed
     */
    public function index(SubscriberRequest $request, SubscriberDataTable $dataTable)
    {
        return $dataTable->render('Newsletter::subscribers.index');
    }

    /**
     * @param SubscriberRequest $request
     * @return $this
     */
    public function create(SubscriberRequest $request)
    {
        $subscriber = new Subscriber();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Newsletter::subscribers.create_edit')->with(compact('subscriber'));
    }

    /**
     * @param SubscriberRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SubscriberRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);
            $mailLists = $request->get('mail_lists', []);
            $subscriber = Subscriber::create($data);
            $subscriber->mailLists()->sync($mailLists);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Subscriber::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param SubscriberRequest $request
     * @param Subscriber $subscriber
     * @return Subscriber
     */
    public function show(SubscriberRequest $request, Subscriber $subscriber)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $subscriber->email])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $subscriber->hashed_id . '/edit']);

        $subscriber->mail_lists_count = $subscriber->mailLists()->count();

        return view('Newsletter::subscribers.show')->with(compact('subscriber'));
    }

    /**
     * @param SubscriberRequest $request
     * @param Subscriber $subscriber
     * @return $this
     */
    public function edit(SubscriberRequest $request, Subscriber $subscriber)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $subscriber->email])]);

        return view('Newsletter::subscribers.create_edit')->with(compact('subscriber'));
    }

    /**
     * @param SubscriberRequest $request
     * @param Subscriber $subscriber
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SubscriberRequest $request, Subscriber $subscriber)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $mailLists = $request->get('mail_lists', []);

            $subscriber->update($data);

            $subscriber->mailLists()->sync($mailLists);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Subscriber::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param SubscriberRequest $request
     * @param Subscriber $subscriber
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SubscriberRequest $request, Subscriber $subscriber)
    {
        try {
            $subscriber->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Subscriber::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param SubscriberRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importSubscribersView(SubscriberRequest $request)
    {
        $this->setViewSharedData([
            'title' => 'Newsletter::module.subscriber_import.title',
        ]);

        return view('Newsletter::subscribers.import.import_subscribers');
    }


    public function importSubscribers(SubscriberImportRequest $request)
    {
        $wrongCounter = 0;
        $successCounter = 0;

        try {
            Excel::load($request->file('subscribers_file'), function ($reader) use (&$wrongCounter, &$successCounter) {
                $wrongData = [];

                foreach ($reader->toArray() as $row) {
                    $mailLists = $row['mail_lists'] ?? '';

                    $mailLists = array_map('trim', explode(config('newsletter.models.subscriber.import.delimiter'), $mailLists));

                    $mailListsObjects = MailList::query()->whereIn('name', $mailLists)->get();

                    $validMailLists = $mailListsObjects->count() == count(array_filter($mailLists));

                    $validator = Validator::make($row, [
                        'name' => 'max:191',
                        'email' => 'required|email|max:191|unique:newsletter_subscribers,email',
                    ]);

                    if ($validator->fails() or !$validMailLists) {
                        $errors = $validator->errors()->all();

                        if (!$validMailLists) {
                            $errors = array_merge($errors, [trans('Newsletter::exception.subscribers.unknown_mail_list')]);
                        }

                        $row['errors'] = '[' . implode(", ", $errors) . ']';

                        $wrongData[] = $row;

                        $wrongCounter++;
                    } else {
                        unset($row['mail_lists']);

                        $ids = $mailListsObjects->pluck('id')->toArray();

                        $subscriber = Subscriber::create($row);

                        $subscriber->mailLists()->sync($ids);

                        $successCounter++;
                    }
                }

                if (count($wrongData) > 0) {
                    $reportFileName = 'subscribers_errors_' . Carbon::now()->format('Y-m-d_h-m-s');

                    \Excel::create($reportFileName, function ($excel) use ($wrongData) {
                        $excel->sheet('sheet', function ($sheet) use ($wrongData) {
                            $sheet->setOrientation('landscape');
                            $sheet->fromArray($wrongData);
                        });
                    })->store('xls', storage_path('errors'));

                    session()->put('import-subscribers-report', storage_path('errors/' . $reportFileName . '.xls'));
                }
            });

            flash(trans('Newsletter::messages.subscriber.success.import',
                ['successCount' => $successCounter, 'wrongCount' => $wrongCounter]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Subscriber::class, 'importSubscribers');
        }

        return redirectTo($this->resource_url);
    }

    public function importSubscribersReport(SubscriberRequest $request, $action)
    {
        switch ($action) {
            case 'download':
                $file = session('import-subscribers-report');

                if (\File::exists($file)) {
                    return response()->download($file);
                }

                flash(trans('Newsletter::exception.subscribers.no_file'))->warning();

                return redirectTo($this->resource_url);
                break;
            case 'clear':
                @unlink(session('import-subscribers-report'));
                session()->forget('import-subscribers-report');
                return redirectTo($this->resource_url);
                break;
        }
    }
}