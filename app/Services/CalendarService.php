<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use DateTime;

class CalendarService
{
    public function store($curse_id, $calendars)
    {
        if($calendars) {
            foreach ($calendars as $calendar) {
                $dateInit = new DateTime($calendar['hour_start']);
                $dateFinish = new DateTime($calendar['hour_end']);
                $dateInit->format('H:i:s');
                $dateFinish->format('H:i:s');
                $calendarQuery[] = array('course_id' => $curse_id,
                                    'day_week' => $calendar['day'],
                                    'hour_init' => $dateInit,
                                    'hour_finish' => $dateFinish,
                                    'periodicity' => $calendar['periodicity']
                                   );
            };
            DB::table('calendar_courses')->where('course_id', $curse_id)->delete();
            DB::table('calendar_courses')->insert($calendarQuery);
        }
        return true;
    }
}