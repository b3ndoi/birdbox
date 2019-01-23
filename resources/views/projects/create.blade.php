@extends('layouts.app')

@section('content')
    <h1>Create a project</h1>
    <form action="/projects" method="POST">
        {{csrf_field()}}
        <div class="field">
            <label for="" class="label">Title</label>
            <div class="control">
                <input type="text" name="title" class="input">
            </div>
        </div>

        <div class="field">
            <label for="" class="label">Title</label>
            <div class="control">
                <textarea type="text" name="description" class="textarea"></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link">Create Project</button>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <a href="/projects" class="button is-link">Cancel</a>
            </div>
        </div>

    </form>
@endsection