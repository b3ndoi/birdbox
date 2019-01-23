@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4 ">
        <div class="flex justify-between w-full items-end">

            <p  class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal">My projects</a>
                 / {{$project->title}}
            </p>

            <a href="{{$project->path().'/edit'}}" class="button">Edit project</a>

        </div>
    </header>
    <main >
        <div class="lg:flex -mx-3 ">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2  class="text-lg  text-grey font-normal mb-3">Tasks</h2>
                    @foreach($project->tasks as $task)
                    <div class="card mb-3">
                    <form action="{{$task->path()}}" method="post" >
                        @method('PATCH')
                        @csrf
                        <div class="flex">
                            <input type="text" name="body" class="w-full {{$task->completed?'text-grey':''}}" value="{{$task->body}}">
                            <input type="checkbox" name="completed" onChange="this.form.submit()" {{$task->completed?'checked':''}}>
                        </div>
                    </form>
                        
                    </div>
                    @endforeach                
                    <div class="card mb-3">
                        <form action="{{$project->path()}}/tasks" method="post">
                            @csrf
                            <input type="text" name="body" class="w-full" placeholder="Add a new tasks...">
                        </form>
                    </div>
                </div>
                <div>
                    <h2  class="text-lg  text-grey font-normal mb-3">General Notes</h2>
                    <form method="POST" action="{{$project->path()}}">
                        @method('PATCH')
                        @csrf
                        <textarea class="card w-full" name="notes">{{$project->notes}}</textarea>
                        <button type="submit" class="button">Save</button>
                    </form>
                </div>
                
           </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>
    
@endsection