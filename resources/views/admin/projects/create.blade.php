@extends('layouts.app')

@section('title', "Create a new project | RF")

@section('content')
    {{-- fai il form --}}
    @include('layouts.partials.form', ['method' => 'post', 'route' => 'admin.projects.store', 'orderBy' => '', 'project'])
@endsection