<?php

namespace Corals\Modules\Utility\Http\Controllers\Comment;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Utility\Classes\Comment\CommentManager;
use Corals\Modules\Utility\Http\Requests\Comment\CommentRequest;
use Corals\Modules\Utility\DataTables\Comment\CommentsDataTable;
use Corals\Modules\Utility\Models\Rating\Rating;
use Corals\Modules\Utility\Models\Comment\Comment;

class CommentBaseController extends BaseController
{
    protected $commentableClass = null;
    protected $redirectUrl = null;
    protected $successMessage = 'Utility::messages.comment.success.add';

    public function __construct()
    {
        $this->setCommonVariables();

        $this->resource_url = config('utility.models.comment.resource_url');

        $this->title = 'Utility::module.comment.title';
        $this->title_singular = 'Utility::module.comment.title_singular';

        parent::__construct();
    }

    protected function setCommonVariables()
    {
        $this->commentableClass = null;
        $this->redirectUrl = null;
    }

    /**
     * @param CommentRequest $request
     * @param $rateable_hashed_id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @param CommentRequest $request
     * @param CommentsDataTable $dataTable
     * @return mixed
     */
    public function index(CommentRequest $request, CommentsDataTable $dataTable)
    {
        $this->setViewSharedData(['hideCreate' => true]);
        return $dataTable->render('Utility::comment.index');
    }

    public function createComment(CommentRequest $request, $commentable_hashed_id)
    {
        try {
            if (is_null($this->commentableClass)) {
                abort(400);
            }

            $commentable = $this->commentableClass::findByHash($commentable_hashed_id);

            if (!$commentable) {
                abort(404);
            }

            $data = $request->all();

            $commentableClass = new CommentManager($commentable, user());

            $commentableClass->createComment([
                'body' => $data['body'],
            ]);

            $message = ['level' => 'success', 'message' => trans($this->successMessage)];
        } catch (\Exception $exception) {
            log_exception($exception, get_class($this), 'createComment');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        if ($request->ajax() || is_null($this->redirectUrl) || $request->wantsJson()) {
            return response()->json($message);
        } else {
            if ($message['level'] === 'success') {
                flash($message['message'])->success();
            } else {
                flash($message['message'])->error();
            }
            redirectTo($this->redirectUrl);
        }
    }

    /**
     * @param CommentRequest $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CommentRequest $request, Comment $comment)
    {
        try {
            $comment->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Comment::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
