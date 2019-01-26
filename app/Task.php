<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
class Task extends EloquentModel
{
    protected $guarded = [
        'id'
    ];
    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static function boot(){

        parent::boot();

        static::created(function ($task){
            $task->project->recordActivity('created_task');
        });

    }

    public function path(){
        return '/projects/'.$this->project->id.'/tasks/'.$this->id;
    }
    public function project(){
        return $this->belongsTo('App\Project');
    }
    public function complete(){
        $this->update([
            'completed' => true
        ]);

        $this->project->recordActivity('completed_task');
    }
}
