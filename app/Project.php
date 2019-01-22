<?php

namespace App;

use App\Model;

class Project extends Model
{
    public function path(){
        return '/projects/'.$this->id;
    }

    public function owner(){
        return $this->belongsTo('App\User', 'owner_id');
    }
}
