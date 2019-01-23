@extends('layouts.app')

@section('content')
    <h1>Edit your project</h1>
    <form action="{{$project->path()}}" method="POST">
    {{csrf_field()}}
    @method('PATCH')
    @include('projects.form',[ 'submit' => 'Edit Project'])
    </form>
@endsection