<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name','slug','location', 'deadlines','stages','start_date', 'end_date','si_rent','open'];


    public function setNameAttribute($value){

        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function registration(){
        return $this->hasMany('App\EventRegistration');
    }

    public function deadline(){
        return $this->hasMany('App\Deadline');
    }
 }
