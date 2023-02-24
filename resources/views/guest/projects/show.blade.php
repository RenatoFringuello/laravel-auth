@extends('layouts.app')

@section('title', "Project $project->title | RF")

@section('content')
        <div class="col-12 col-md-8 mt-5 mx-auto text-decoration-none text-black">
            <div class="card p-2">
                <h2>{{ $project->title }}</h2>
                <pre class="text-secondary fs-5">{{ $project->author_name . ' ' . $project->author_lastname }}</pre>
                <p>{{$project->content}}</p>
                <div>{{ $project->start_date->format('Y-m-d') }}</div>
                <div class="mb-2 text-success {{ $project->end_date ?? 'text-danger' }}">{{ isset($project->end_date) ? $project->end_date->format('Y-m-d'): 'work in progress' }}</div>
            </div>
        </div>
    </div>
@endsection