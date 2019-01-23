<?php

namespace App;

use App\Model;
class Task extends Model
{

    protected $touches = ['project'];

    public function path(){
        return '/projects/'.$this->project->id.'/tasks/'.$this->id;
    }
    public function project(){
        return $this->belongsTo('App\Project');
    }
}
