@extends('layouts.app')

@section('title', "Edit project n°$project->id | RF")

@section('content')
    {{-- fai il form --}}
    @include('layouts.partials.form', ['method' => 'PUT', 'route' => 'admin.projects.update', 'orderBy' => null, 'project' => $project])
@endsection