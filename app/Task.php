<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
class Task extends EloquentModel
{
    use RecordActivity;
    protected $guarded = [
        'id'
    ];

    protected static $recordableEvents = ['created', 'deleted'];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    // protected static function boot(){

    //     parent::boot();

    //     static::created(function ($task){
    //         $task->project->recordActivity('created_task');
    //     });
    //     static::deleted(function ($task){
    //         $task->project->recordActivity('deleted_task');
    //     });

    // }

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

        $this->recordActivity('completed_task');
    }
    public function incomplete(){
        $this->update([
            'completed' => false
        ]);

        $this->recordActivity('incompleted_task');
    }

    

}
