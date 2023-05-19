@extends('layouts.app')

@section('title', count($projects). ' projects | RF')

@section('content')
    <div class="mh-100vh pt-4">
        <div class="mt-5">
            {{-- homepage --}}
            {{ $projects->links()}}
        </div>
        <div class="row g-3 mb-3">
            @forelse ($projects as $project)
                <a  href="{{route('guest.projects.show', $project)}}" 
                    class="col-12 col-sm-6 col-lg-4 text-decoration-none text-black">

                    <div class="card p-2 h-100 d-flex flex-column justify-content-between">
                        <div class="top d-flex flex-wrap">
                            <img class="rounded-1 img-fluid mb-3" src="{{$project->image}}" alt="{{$project->title.'\'s thumbnail'}}">
                            <div>
                                <h4 class="mb-0">{{ $project->title }}</h4>
                                <pre class="text-secondary mb-2">{{ $project->user->name . ' ' . $project->user->lastname }}</pre>
                                <p class="mb-2">{{ $project->content }}</p>
                            </div>
                        </div>
                        <div class="bottom">
                            <div>{{ $project->start_date->format('Y-m-d') }}</div>
                            <div class="text-success {{ $project->end_date ?? 'text-danger' }}">{{ isset($project->end_date) ? $project->end_date->format('Y-m-d'): 'work in progress' }}</div>
                        </div>
                    </div>
                </a>

            @empty

                <h1 class="text-center pt-5 mt-5 text-secondary">
                    Non ci sono progetti da visualizzare
                </h1>
            @endforelse
        </div>
        {{ $projects->links()}}
    </div>
@endsection
