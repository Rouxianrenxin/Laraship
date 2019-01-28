<?php

namespace Corals\Modules\Newsletter\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Newsletter\DataTables\MailListDataTable;
use Corals\Modules\Newsletter\DataTables\MailListSubscriberDataTable;
use Corals\Modules\Newsletter\Http\Requests\MailListRequest;
use Corals\Modules\Newsletter\Models\MailList;

class MailListsController extends BaseController
{
    protected $excludedRequestParams = [];

    public function __construct()
    {
        $this->resource_url = config('newsletter.models.mail_list.resource_url');

        $this->title = 'Newsletter::module.mail_list.title';
        $this->title_singular = 'Newsletter::module.mail_list.title_singular';

        parent::__construct();
    }

    /**
     * @param MailListRequest $request
     * @param MailListDataTable $dataTable
     * @return mixed
     */
    public function index(MailListRequest $request, MailListDataTable $dataTable)
    {
        return $dataTable->render('Newsletter::mail_lists.index');
    }

    /**
     * @param MailListRequest $request
     * @return $this
     */
    public function create(MailListRequest $request)
    {
        $mailList = new MailList();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Newsletter::mail_lists.create_edit')->with(compact('mailList'));
    }

    /**
     * @param MailListRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(MailListRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $mailList = MailList::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, MailList::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param MailListRequest $request
     * @param MailList $mailList
     * @return MailList
     */
    public function show(MailListRequest $request, MailList $mailList)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $mailList->name])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $mailList->hashed_id . '/edit']);

        $mailList->subscribers_count = $mailList->subscribers()->count();

        return view('Newsletter::mail_lists.show')->with(compact('mailList'));
    }

    /**
     * @param MailListRequest $request
     * @param MailList $mailList
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(MailListRequest $request, MailList $mailList)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $mailList->name])]);

        return view('Newsletter::mail_lists.create_edit')->with(compact('mailList'));
    }

    /**
     * @param MailListRequest $request
     * @param MailList $mailList
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(MailListRequest $request, MailList $mailList)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $mailList->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, MailList::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param MailListRequest $request
     * @param MailList $mailList
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MailListRequest $request, MailList $mailList)
    {
        try {
            $mailList->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, MailList::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function mailListsSubscribers(MailListRequest $request, MailList $mailList, MailListSubscriberDataTable $dataTable)
    {
        $title = trans('Newsletter::module.mail_list.subscribers_title', ['name' => $mailList->name]);

        $this->setViewSharedData([
            'title' => $title,
            'title_singular' => $title,
            'hideCreate' => true
        ]);

        return $dataTable->render('Newsletter::mail_lists.mail_list_subscribers');
    }
}