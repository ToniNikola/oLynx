<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    protected $fillable = ['event_id', 'deadline', 'value1','value2','value3'];

    public function event(){
        return $this->belongsTo('App\Event');
    }

}
