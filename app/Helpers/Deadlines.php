<?php

namespace App\Helpers;

use App\Deadline;
use App\Event;
use Carbon\Carbon;
use DateTime;

class Deadlines {


    /**
     * Compare registration_date and deadlines_date
     * Return deadline no. if registration_date did not pass deadline_date.
     *
     * @param $runner_created_at
     * @param array $deadlines
     * @return int
     */
    public static function compare($runner_created_at, array $deadlines)
    {
        for ($dd = 0; count($deadlines) > $dd; $dd ++)
        {
            $date = new DateTime($deadlines[$dd]);

            //Compare Registration date and deadlines(+1 day -1 second)

            if (new DateTime($runner_created_at) < $date->modify('+1 day -1 second'))
            {
                return $dd + 1;
            }
        }

        return $deadline = count($deadlines) + 1;

    }

    /**
     * Check if last deadline is passed.
     *
     * @param array $deadlines
     * @return bool
     */
    public static function checkLastDeadline(array $deadlines)
    {
        $deadline = new DateTime(end($deadlines));
        $deadline_end = $deadline->modify('+1 day -1 second');

        $today = Carbon::now();

        if ($today > $deadline_end)
        {
            return true;
        }

        return false;
    }

    /**
     * Format deadlines string to dates and return array.
     *
     * @param $event_id
     * @return array
     */
    public static function format($event_id)
    {

        $deadlines = Deadline::where('event_id', $event_id)->first();

        if (is_object($deadlines))
        {
            $deadlines_array = str_split($deadlines->deadline, 10);
            $deadlines = [];
            foreach ($deadlines_array as $string)
            {
                $deadlines[] .= date('Y-m-d', $string);
            }

            return $deadlines;
        }

    }

    public static function checkIfSet($event_id)
    {

        $check = count(Deadline::where('event_id', $event_id)->get());

        if ($check == 0)
        {
            return false;
        }

        return true;
    }

    public static function convertDeadlineToDate($deadlines_str)
    {

        $array = str_split($deadlines_str, 10);


        $deadlines = [];
        foreach ($array as $string)
        {
            $deadlines[] .= date('d-m-Y', $string);
        }

        return $deadlines;
    }

    public function getDeadlineValue($event_id, $deadline_num)
    {
        $deadlines = Deadline::where('event_id', $event_id)->get();

        $deadline = $deadlines[$deadline_num - 1];

        dd($deadline->value1);

    }
}
