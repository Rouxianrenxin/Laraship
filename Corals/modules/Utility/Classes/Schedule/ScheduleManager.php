<?php

namespace Corals\Modules\Utility\Classes\Schedule;

use Corals\Modules\Utility\Models\Schedule\Schedule as ScheduleModel;
use Carbon\Carbon;


class ScheduleManager
{

    protected $instance;

    public function __construct($instance)
    {
        $this->instance = $instance;

    }

    public function createSchedule($schedule)
    {
        foreach ($schedule as $day => $value) {
            $data_schedules = [
                'scheduleable_id' => $this->instance->id,
                'scheduleable_type' => get_class($this->instance),
                'user_id' => user()->id,
                'day_of_the_week' => $day,
                'start_time' => $value['start'] == 'Off' ? null : Carbon::createFromFormat('H', $value['start']),
                'end_time' => $value['end'] == 'Off' ? null : Carbon::createFromFormat('H', $value['end']),
            ];
            ScheduleModel::create($data_schedules);
        }
    }

    public function getSchedule()
    {
        $schedules = [];

        foreach (\Settings::get('utility_days_of_the_week', []) as $key => $day) {
            $schedules = array_merge($schedules, [
                $key => [
                    'start' => in_array($key, ['Sat', 'Sun']) ? 'Off' : '08',
                    'end' => in_array($key, ['Sat', 'Sun']) ? 'Off' : '17',
                ]
            ]);
        }

        if ($this->instance) {
            foreach ($this->instance->schedules as $schedule) {
                $schedules[$schedule->day_of_the_week] = [
                    'start' => is_null($schedule->start_time) ? 'Off' : Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('H'),
                    'end' => is_null($schedule->end_time) ? 'Off' : Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('H'),
                ];
            }
        }
        return $schedules;

    }

    public function updateSchedule($schedule)
    {
        foreach ($schedule as $day => $value) {
            $this->instance->schedules()->updateOrCreate(['day_of_the_week' => $day],
                [
                    'start_time' => $value['start'] == 'Off' ? null : Carbon::createFromFormat('H', $value['start']),
                    'end_time' => $value['end'] == 'Off' ? null : Carbon::createFromFormat('H', $value['end']),
                ]
            );
        }
    }

}