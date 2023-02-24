@extends('layouts.app')

@section('title', count($projects). ' projects | RF')

@section('content')
    {{-- homepage --}}
    {{ $projects->links()}}
    <div class="row g-3 mb-3">
        @foreach ($projects as $project)
            <a href="{{route('guest.projects.show', $project)}}" class="col-12 col-sm-6 col-lg-4 col-xl-3 text-decoration-none text-black">
                <div class="card p-2">
                    <h4>{{ $project->title }}</h4>
                    <pre class="text-secondary">{{ $project->author_name . ' ' . $project->author_lastname }}</pre>
                    <p>{{ $project->content }}</p>
                    <div>{{ $project->start_date->format('Y-m-d') }}</div>
                    <div class="text-success {{ $project->end_date ?? 'text-danger' }}">{{ isset($project->end_date) ? $project->end_date->format('Y-m-d'): 'work in progress' }}</div>
                </div>
            </a>
        @endforeach     
    </div>
    {{ $projects->links()}}
@endsection
