<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;

class ProjectsTasksController extends Controller
{
    public function store(Project $project){

        $this->authorize('update', $project);
        
        request()->validate([
            'body' => 'required'
        ]);

        $project->addTask(request('body'));
        return redirect($project->path());
    }

    public function update(Project $project, Task $task){
        
        $this->authorize('update', $task->project);

        $attributes = request()->validate([
            'body' => 'required'
        ]);

        $task->update($attributes);
        $method = request('completed')? 'complete' : 'incomplete';

        $task->$method();
        // if(request('completed')){
        //     $task->complete();
        // }else{
        //     $task->incomplete();
        // }
        return redirect($project->path());
    }
}
