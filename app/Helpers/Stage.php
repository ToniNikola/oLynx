<?php

namespace App\Helpers;

use App\Stages;

class Stage {

    public static function checkIfSet($event_id)
    {

        $check = count(Stages::where('event_id', $event_id)->first());
        if ($check !== 1)
        {
            return false;
        }
        return true;
    }
}