@extends('layouts.app')

@section('content')
    <h1>Lets start something new</h1>
    <form action="/projects" method="POST">
    {{csrf_field()}}
    @include('projects.form', ['project'=> new App\Project, 'submit' => 'Create Project'])
    </form>
@endsection