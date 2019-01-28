<?php

namespace Corals\Modules\Utility\Traits\Schedules;

use Corals\Modules\Utility\Models\Schedule\Schedule;
use Illuminate\Database\Eloquent\Model;
use Corals\Modules\Utility\Models\Schedule\Schedule as ScheduleModel;
use Carbon\Carbon;

trait Scheduleable
{
    public static function bootScheduleable()
    {
        static::deleted(function (Model $deletedModel) {

            $deletedModel->schedules()->delete();

        });
    }

    public function schedules()
    {
        return $this->morphMany(Schedule::class, 'scheduleable');
    }

    public function isOpen()
    {
        $dayOfWeek = Carbon::now()->format('l');

        $today = substr($dayOfWeek, 0, 3);

        $currentTime = date('h:i:s');

        $open = ScheduleModel::query()->where('day_of_the_week', $today)
            ->where('scheduleable_id', $this->id)
            ->where(function ($parent) use ($currentTime) {
                $parent->where('start_time', '<=', $currentTime)
                    ->Where('end_time', '>=', $currentTime);
            })->first();

        if ($open) {

            return true;
        } else {

            return false;
        }
    }


}