<?php

namespace App\Helpers;

use App\EventRegistration;

class RegistrationHelper{
    public static function checkIfRegistered($event_id)
    {
        $count = EventRegistration::where('event_id', $event_id)->where('user_id', \Auth::id())->get()->count();

        if($count !== 0){
            return true;
        }
        return false;
    }
}