<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model {

    protected $fillable = ['event_id', 'first_name', 'last_name', 'birth_year', 'club', 'country', 'category', 'deadline', 'si_chip', 'stages',];

    public function event()
    {
        $this->belongsTo('App\Event');
    }


}

