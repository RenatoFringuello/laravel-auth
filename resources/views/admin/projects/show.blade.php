@extends('layouts.app')

@section('title', "Manage project n°$project->id | RF")

@section('content')
    <div class="mh-100vh d-flex">
        <div class="col-12 col-sm-8 col-md-11 col-lg-9 m-auto text-decoration-none text-black">
            <div class="card flex-md-row p-2">
                <div class="left w-md-50 mb-3 mb-md-0">
                    <img src="{{ asset('storage/'.$project->image) }}" class="img-fluid h-100 object-fit-cover object-position-center rounded-1" alt="{{ $project->image }}">
                </div>
                <div class="right w-100 w-md-50 ps-md-4 p-md-3 d-flex flex-column justify-content-between">
                    <div class="top">
                        <h2>{{ $project->title }}</h2>
                        <pre class="text-secondary fs-5 mb-3">{{ $project->author_name . ' ' . $project->author_lastname }}</pre>
                        <p class="mb-3">{{$project->content}}</p>
                    </div>
                    <div class="bottom d-flex align-items-center justify-content-between">
                        <div class="dates-container">
                            <div>{{ $project->start_date->format('Y-m-d') }}</div>
                            <div class="text-success {{ $project->end_date ?? 'text-danger' }}">{{ isset($project->end_date) ? $project->end_date->format('Y-m-d'): 'work in progress' }}</div>
                        </div>
                        <div class="btn-container">
                            <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-primary">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            @include('layouts.partials.form', ['method' => 'DELETE', 'route' => 'admin.projects.destroy', 'orderBy'=> null, 'project' => $project, 'extraClasses' => 'btn p-0'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('scripts')
    <script type='module' src="{{Vite::asset('./resources/js/popUp.js')}}"></script>
@endsection