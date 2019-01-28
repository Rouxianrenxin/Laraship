<?php

namespace Corals\User\Communication\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\User\Communication\DataTables\NotificationTemplatesDataTable;
use Corals\User\Communication\Facades\CoralsNotification;
use Corals\User\Communication\Http\Requests\NotificationTemplateRequest;
use Corals\User\Communication\Models\NotificationTemplate;

class NotificationTemplateController extends BaseController
{

    public function __construct()
    {
        $this->resource_url = config('notification.models.notification_template.resource_url');

        $this->title = 'Notification::module.notification_template.title';
        $this->title_singular = 'Notification::module.notification_template.title_singular';

        $this->setViewSharedData(['hideCreate' => true]);

        parent::__construct();
    }

    /**
     * @param NotificationTemplateRequest $request
     * @param NotificationTemplatesDataTable $dataTable
     * @return mixed
     */
    public function index(NotificationTemplateRequest $request, NotificationTemplatesDataTable $dataTable)
    {
        CoralsNotification::insertNewEventsToDatabase();
        $showCreateButton = false;
        return $dataTable->render('Notification::notification_template.index', compact('showCreateButton'));
    }

    /**
     * @param NotificationTemplateRequest $request
     * @param NotificationTemplate $notification_template
     * @return $this
     */
    public function edit(NotificationTemplateRequest $request, NotificationTemplate $notification_template)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $notification_template->friendly_name])]);

        $notificationParametersDescription = CoralsNotification::getNotificationParametersDescription($notification_template);

        return view('Notification::notification_template.create_edit')->with(compact('notification_template', 'notificationParametersDescription'));
    }

    /**
     * @param NotificationTemplateRequest $request
     * @param NotificationTemplate $notification_template
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(NotificationTemplateRequest $request, NotificationTemplate $notification_template)
    {
        try {
            $data = $request->except('role_ids');
            $data['extras'] = $request->get('extras', []);
            $data['via'] = $request->get('via', []);
            $rolesIds = $request->get('role_ids', []);
            $notification_template->roles()->sync($rolesIds);
            $notification_template->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => 'NotificationTemplate']))->success();
        } catch (\Exception $exception) {
            log_exception($exception, NotificationTemplate::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

}
