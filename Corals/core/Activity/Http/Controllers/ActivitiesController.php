<?php

namespace Corals\Activity\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Activity\DataTables\ActivitiesDataTable;
use Corals\Activity\Http\Requests\ActivityRequest;
use Corals\Activity\Models\Activity;

class ActivitiesController extends BaseController
{

    public function __construct()
    {
        $this->resource_url = config('activity.models.activity.resource_url');

        $this->title = 'Activity::module.activity.title';
        $this->title_singular = 'Activity::module.activity.title_singular';

        parent::__construct();
    }

    /**
     * @param ActivityRequest $request
     * @param ActivitiesDataTable $dataTable
     * @return mixed
     */
    public function index(ActivityRequest $request, ActivitiesDataTable $dataTable)
    {
        return $dataTable->render('Activity::activities.index');
    }

    public function show(Activity $activity)
    {
        return $activity;
    }

    /**
     * @param ActivityRequest $request
     * @param Activity $activity
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ActivityRequest $request, Activity $activity)
    {
        try {
            $activity->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Activity::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}