<?php

namespace Corals\Modules\Announcement\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Announcement\DataTables\AnnouncementsDataTable;
use Corals\Modules\Announcement\Http\Requests\AnnouncementRequest;
use Corals\Modules\Announcement\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementsController extends BaseController
{
    protected $excludedRequestParams = ['roles', 'image'];

    public function __construct()
    {
        $this->resource_url = config('announcement.models.announcement.resource_url');

        $this->title = 'Announcement::module.announcement.title';
        $this->title_singular = 'Announcement::module.announcement.title_singular';

        $this->corals_middleware_except = array_merge($this->corals_middleware_except,
            ['show', 'markAnnouncementAsRead', 'getUnreadAnnouncements']);

        parent::__construct();
    }

    /**
     * @param AnnouncementRequest $request
     * @param AnnouncementsDataTable $dataTable
     * @return mixed
     */
    public function index(AnnouncementRequest $request, AnnouncementsDataTable $dataTable)
    {
        if (user()->can('Announcement::announcement.access_all')) {
            return $dataTable->render('Announcement::announcements.index');
        } else {
            $this->setViewSharedData(['hideCreate' => true]);
            $announcements = Announcement::query();

            $announcements = $announcements->join('model_has_roles', 'model_id', 'announcements.id')
                ->where('model_type', Announcement::class)
                ->whereIn('role_id', user()->roles()->pluck('id')->toArray());

            $grid_items = $announcements->paginate();

            $grid_item_view = 'Announcement::announcements.grid_item';

            return view('Announcement::announcements.grid')->with(compact('grid_item_view', 'grid_items'));
        }
    }

    /**
     * @param AnnouncementRequest $request
     * @return $this
     */
    public function create(AnnouncementRequest $request)
    {
        $announcement = new Announcement();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Announcement::announcements.create_edit')->with(compact('announcement'));
    }

    /**
     * @param AnnouncementRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(AnnouncementRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $announcement = Announcement::create($data);

            $announcement->assignRole($request->get('roles', []));

            if ($request->hasFile('image')) {
                $announcement->addMedia($request->file('image'))
                    ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
                    ->toMediaCollection($announcement->mediaCollectionName);
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Announcement::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param Request $request
     * @param Announcement $announcement
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Announcement $announcement)
    {
        \Announcement::doRead($announcement);

        return view('Announcement::announcements.show')->with(compact('announcement'));
    }

    /**
     * @param Request $request
     * @param Announcement $announcement
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAnnouncementAsRead(Request $request, Announcement $announcement)
    {
        \Announcement::doRead($announcement);

        return response()->json(['success']);
    }

    /**
     * @param AnnouncementRequest $request
     * @param Announcement $announcement
     * @return $this
     */
    public function edit(AnnouncementRequest $request, Announcement $announcement)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $announcement->getIdentifier()])]);

        return view('Announcement::announcements.create_edit')->with(compact('announcement'));
    }

    /**
     * @param AnnouncementRequest $request
     * @param Announcement $announcement
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $data['show_immediately'] = array_get($data, 'show_immediately', false);

            $data['is_public'] = array_get($data, 'is_public', false);

            $announcement->update($data);

            $announcement->syncRoles($request->get('roles', []));

            if ($request->hasFile('image')) {
                $announcement->clearMediaCollection($announcement->mediaCollectionName);

                $announcement->addMedia($request->file('image'))
                    ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
                    ->toMediaCollection($announcement->mediaCollectionName);
            }

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Announcement::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param AnnouncementRequest $request
     * @param Announcement $announcement
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AnnouncementRequest $request, Announcement $announcement)
    {
        try {
            $announcement->clearMediaCollection($announcement->mediaCollectionName);

            $announcement->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Announcement::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getUnreadAnnouncements(Request $request)
    {
        $currentURL = $request->get('current_url');

        $announcements = \Announcement::unreadAnnouncements(user(), false, null,
            ['show_in_url' => $currentURL], ['show_immediately' => true]);

        $unread_announcements = [];

        $firstLoop = true;

        foreach ($announcements as $announcement) {
            $unread_announcements[] = ['src' => view('Announcement::announcements.show')
                ->with(['announcement' => $announcement])->render(),
                'type' => 'inline',
                'hashed_id' => $announcement->hashed_id,
                'read_url' => url('announcements/mark-announcement-as-read/' . $announcement->hashed_id),
                'read' => $firstLoop,
            ];

            if ($firstLoop) {
                \Announcement::doRead($announcement);
                $firstLoop = false;
            }
        }

        return response()->json($unread_announcements);
    }
}
