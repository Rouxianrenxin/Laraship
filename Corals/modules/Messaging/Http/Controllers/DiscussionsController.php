<?php

namespace Corals\Modules\Messaging\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Messaging\Http\Requests\DiscussionRequest;
use Illuminate\Http\Request;
use Corals\Modules\Messaging\Models\Discussion;
use Corals\Modules\Messaging\Models\Message;
use Corals\Modules\Messaging\Models\Participation;
use Corals\User\Models\User;
use Corals\Foundation\Search\Search;

class DiscussionsController extends BaseController
{
    protected $excludedRequestParams = [];

    public function __construct()
    {
        $this->resource_url = config('messaging.models.discussion.resource_url');

        $this->title = 'Messaging::module.discussion.title';
        $this->title_singular = 'Messaging::module.discussion.title_singular';

        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function index(DiscussionRequest $request, $status = null)
    {

        $search_term = $request->get('search', null);

        $discussions = user()->discussions($status);

        if (!empty($search_term)) {

            $discussions->newQuery();

            $config = [
                'title_weight' => 10,
                'content_weight' => 10,
                'enable_wildcards' => 10
            ];

            $search = new Search();

            $discussions = $search->AddSearchPart($discussions, $search_term, Discussion::class, $config);
        }

        $discussions = $discussions->orderBy('messaging_discussions.created_at', 'desc')
            ->paginate(\Settings::get('messaging_pagination_number', 10));

        return view('Messaging::discussions.index')->with(compact('discussions', 'search_term', 'status'));
    }

    /**
     * @param DiscussionRequest $request
     * @return $this
     */
    public function create(DiscussionRequest $request)
    {
        $discussion = new Discussion();

        if ($request->has('user')) {
            $hashed_id = $request->get('user');
            $user = User::findByHash($hashed_id);
            $discussion->user_id = $user->id;
        }

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Messaging::discussions.create_edit')->with(compact('discussion', 'user'));
    }

    /**
     * @param DiscussionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DiscussionRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $users = [];

            $messageData = [];

            $messageData = [
                'participable_type' => get_class(user()),
                'participable_id' => user()->id,
                'body' => $data['body'] ?? null,
            ];

            $users_id = $data['user_id'];
            $users_id = is_array($users_id) ? $users_id : [$users_id];

            $users_id[] = user()->id;

            $discussion = Discussion::create($data);


            if ($discussion) {

                for ($i = 0; $i < count($users_id); $i++) {
                    $users[] = User::find($users_id[$i]);
                }

                $discussion->addParticipants($users);

                $message = Message::create($messageData);

                $discussion->messages()->save($message);

                $discussion->markAsRead(user());

                $discussion->toggleStatus('read');

                $discussion->indexRecord();

            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Discussion::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param DiscussionRequest $request
     * @param Discussion $discussion
     * @return Discussion
     */
    public function show(DiscussionRequest $request, Discussion $discussion)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $discussion->getIdentifier('subject')])]);

        $this->setViewSharedData();

        if($discussion->hasParticipation(user())) {
            if (user()->newMessagesCount()) {
                $this->markAsRead($discussion, 'read');
            }
        } else {
            abort(403);
        }

        return view('Messaging::discussions.show')->with(compact('discussion'));
    }

    public function markAsRead(Discussion $discussion)
    {
        try {

            $discussion->markAsRead(user());
            $discussion->toggleStatus('read');

            flash(trans('Messaging::messages.success.read', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Discussion::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    public function toggleStatus(Discussion $discussion, $status)
    {
        try {

            $discussion->toggleStatus($status);

            flash(trans('Messaging::messages.success.' . $status, ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Discussion::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    public function bulkAction(Request $request, $status)
    {
        try {
            $data = $request->get('selection');

            foreach ($data as $discussion) {
                $discussion = Discussion::findByHash($discussion);
                if ($status == 'read') {
                    $discussion->markAsRead(user());
                }
                $discussion->toggleStatus($status);
            }

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];

        } catch (\Exception $exception) {
            log_exception($exception, Discussion::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param DiscussionRequest $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DiscussionRequest $request, Discussion $discussion)
    {
        try {
            $discussion->toggleStatus('deleted');

            flash(trans('Corals::messages.success.deleted', ['item' => $this->title_singular]))->success();

        } catch (\Exception $exception) {
            log_exception($exception, Discussion::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return redirectTo($this->resource_url);
    }
}