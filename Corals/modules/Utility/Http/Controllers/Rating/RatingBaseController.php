<?php

namespace Corals\Modules\Utility\Http\Controllers\Rating;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Utility\Classes\Rating\RatingManager;
use Corals\Modules\Utility\Http\Requests\Rating\RatingRequest;
use Corals\Modules\Utility\DataTables\Rating\RatingsDataTable;
use Corals\Modules\Utility\Models\Rating\Rating;

class RatingBaseController extends BaseController
{
    protected $rateableClass = null;
    protected $redirectUrl = null;
    protected $successMessage = 'Utility::messages.rating.success.add';
    protected $successMessageWithPending = 'Utility::messages.rating.success.add_with_pending';

    public function __construct()
    {
        $this->setCommonVariables();

        $this->resource_url = config('utility.models.rating.resource_url');

        $this->title = 'Utility::module.rating.title';
        $this->title_singular = 'Utility::module.rating.title_singular';

        parent::__construct();
    }

    protected function setCommonVariables()
    {
        $this->rateableClass = null;
        $this->redirectUrl = null;
    }

    /**
     * @param RatingRequest $request
     * @param $rateable_hashed_id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @param RatingRequest $request
     * @param RatingsDataTable $dataTable
     * @return mixed
     */
    public function index(RatingRequest $request, RatingsDataTable $dataTable)
    {
        $this->setViewSharedData(['hideCreate' => true]);
        return $dataTable->render('Utility::rating.index');
    }

    public function createRating(RatingRequest $request, $rateable_hashed_id)
    {
        try {

            if (is_null($this->rateableClass)) {
                abort(400);
            }

            $rateable = $this->rateableClass::findByHash($rateable_hashed_id);

            if (!$rateable) {
                abort(404);
            }

            $data = $request->all();

            $ratingClass = new RatingManager($rateable, user());

            $rating = $ratingClass->handleModelRating([
                'rating' => $data['review_rating'],
                'title' => $data['review_subject'] ?? null,
                'body' => $data['review_text'] ?? null,
                'criteria' => $data['criteria'] ?? null,
            ]);
            if ($rating->status == 'pending') {
                $message = $this->successMessageWithPending;
            } else {
                $message = $this->successMessage;
            }

            $message = ['level' => 'success', 'message' => trans($message)];
        } catch (\Exception $exception) {
            log_exception($exception, get_class($this), 'createRating');
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
            return redirectTo($this->redirectUrl);
        }
    }

    /**
     * @param RatingRequest $request
     * @param Rating $rating
     * @return $this
     */
    public function edit(RatingRequest $request, Rating $rating)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $rating->title])]);

        return view('Utility::rating.create_edit')->with(compact('rating'));
    }

    /**
     * @param RatingRequest $request
     * @param Rating $rating
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(RatingRequest $request, Rating $rating)
    {

        try {
            if (is_null($rating)) {
                abort(404);
            }

            $data = $request->all();

            $ratingClass = new RatingManager();

            $ratingClass->updateRating($rating, [
                'rating' => $data['review_rating'],
                'title' => $data['review_subject'] ?? null,
                'body' => $data['review_text'] ?? null,
                'status' => $data['status'] ?? null,
                'criteria' => $data['criteria'] ?? null,
            ]);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Rating::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param RatingRequest $request
     * @param Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RatingRequest $request, Rating $rating)
    {

        try {

            $ratingClass = new RatingManager();

            $ratingClass->deleteRating($rating);

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Rating::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }


    /**
     * @param Rating $rating
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function toggleStatus(Rating $rating, $status)
    {
        try {

            $ratingClass = new RatingManager();

            $ratingClass->toggleStatus($rating, $status);

            $message = ['level' => 'success', 'message' => trans('Utility::messages.rating.success.status_update')];
        } catch (\Exception $exception) {

            //$rating->update(['status' => $exception->getMessage()]);
            log_exception($exception, Rating::class, 'toggleStatus');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
