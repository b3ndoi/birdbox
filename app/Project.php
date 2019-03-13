<?php

namespace App;

use App\Model;

class Project extends Model
{
    use RecordActivity;
    
    public function path(){
        return '/projects/'.$this->id;
    }

    public function owner(){
        return $this->belongsTo('App\User', 'owner_id');
    }


    public function addTask($body){
        $project = $this->tasks()->create(compact('body'));
        
        return $project;
    }

    public function tasks(){
        return $this->hasMany('App\Task');
    }

    public function activity(){
        return $this->hasMany('App\Activity', 'project_id')->latest();
    }
}
