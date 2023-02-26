<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    /**
     * return the data validated
     *
     * @param Request $request
     * @return Array
     */
    protected function getValidatedData(Request $request){
        $validation = [
            'title' => "required|max:50",
            'image' => "image",
            // 'author_name' => 'required|max:100',
            // 'author_lastname' => 'required|max:100',
            'content' => 'required',
            'start_date' => 'required|date|after:1990-12-20 00:00:00',
            'end_date' => 'date|nullable|after:start_date',
        ];
        $validationMessages = [
            'title.required' => 'Il titolo è un campo obbligatorio',
            'title.max' => 'Hai inserito troppi caratteri in title',
            'image.image' => 'Qui puoi inserire solo immagini',
            // 'author_name.required' => 'Il nome dell\'autore è un campo obbligatorio',
            // 'author_name.max' => 'Hai inserito troppi caratteri per il nome',
            // 'author_lastname.required' => 'Il cognome dell\'autore è un campo obbligatorio',
            // 'author_lastname.max' => 'Hai inserito troppi caratteri il cognome',
            'content.required' => 'Il contenuto del progetto è un campo obbligatorio',
            'start_date.required' => 'La data di inizio è un campo obbligatorio',
            'start_date.date' => 'La data di inizio che hai scritto non esiste in nessun calendario neanche in quello dei maya',
            'start_date.after' => 'Non puoi aver iniziato a creare un sito prima della sua invenzione',
            'end_date.date' => 'La data di fine che hai scritto non esiste. Lascia il campo vuoto se il lavoro non è finito',
            'end_date.after' => 'Il progetto non può finire ancor prima che inizi',
        ];
        return $request->validate($validation, $validationMessages);
    }


    /**
     * Display a listing of the resource.
     *
     * @param  string $field
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //get the oppsite of dir passed by get
        $dir = !$request->dir;
        //get the order by field
        $orderBy = $request->sort;
        //manage author
        $orderBy = ($orderBy == 'author') ? 'author_lastname' : $orderBy;
        
        $projects = Project::where('user_id', '=', Auth::user()->id)->orderBy($orderBy ?? 'id', ($dir) ? 'ASC' : 'DESC')->paginate(10)->withQueryString()->all();
        // dd($projects);

        $fields = ['Title', 'Start Date', 'End Date'];

        return view('admin.projects.index',  compact('projects', 'fields', 'orderBy', 'dir'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = new Project();
        return view('admin.projects.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->getValidatedData($request);
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = Auth::user()->id;
        // dd($data);
        $data['image'] = (!isset($data['image'])) ? 'images/projects/placeholder.jpg' : Storage::put('/images/projects',$data['image']);
        $project = new Project();
        $project->fill($data);
        $project->save();
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project  $project)
    {
        $data = $this->getValidatedData($request);
        $data['slug'] = Str::slug($data['title']);

        // dd($data['image']);
        $data['image'] = (!isset($data['image'])) ? 'images/projects/placeholder.jpg' : Storage::put('/images/projects',$data['image']);
        //se l'immagine da cambiare è diversa dal placeholder eliminala dallo storage
        if($project->image != 'images/projects/placeholder.jpg')
            Storage::delete('/images/projects', $project->image);
        $project->update($data);
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project  $project, Request $request)
    {
        //qui la logica funziona
        if($project->image != 'images/projects/placeholder.jpg')
            Storage::delete('/images/projects',$project->image);
        Project::destroy($project->id);
        $orderBy = $request->sort;
        // dd($orderBy);
        return redirect()->route('admin.projects.index', ['sort' => $orderBy ?? 'id']);
    }
}
