<?php

namespace App;

trait RecordActivity{
    public $old = [];

    public static function bootRecordActivity(){
        

        if(isset(static::$recordableEvents)){
            $recordableEvents = static::$recordableEvents;
        }else{
            $recordableEvents = ['created', 'updated', 'deleted'];
        }

        foreach($recordableEvents as $event){
            static::$event(function($model) use($event){
                if(class_basename($model) !== 'Project'){
                    $event = "{$event}_". strtolower(class_basename($model));
                }
                $model->recordActivity($event);
            });

            if($event === 'updated'){
                static::updating(function($model){
                    $model->old = $model->getOriginal();
                });
            }
        }
    }

    public function recordActivity($description){
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this)==='Project'? $this->id:$this->project_id,
        ]);
    }

    protected function activityChanges(){
        return $this->wasChanged()?[
            'before' => array_diff($this->old, $this->getAttributes()),
            'after' => array_diff($this->getAttributes(), $this->old)
        ]:null;
    }

    public function activity(){
        return $this->morphMany('App\Activity', 'subject')->latest();
    }
}