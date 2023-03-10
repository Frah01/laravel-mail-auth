<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmProject;
use App\Models\Lead;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $technologies = Technology::all();
        $types = Type::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $form_data = $request->validated();
        $slug = Project::generateSlug($request->title);
        $form_data['slug'] = $slug;
        $newProject = new Project();
        if ($request->hasFile('cover_image')) {
            $path = Storage::disk('public')->put('post_images', $request->cover_image);

            $form_data['cover_image'] = $path;
        }

        $newProject->fill($form_data);
        $newProject->save();
        if ($request->has('technologies')) {
            $newProject->technologies()->attach($request->technologies);
        }
        $newLead = new Lead();
        $newLead->title = $form_data['title'];
        $newLead->content = $form_data['content'];
        $newLead->slug = $form_data['slug'];
        $newLead->save();
        Mail::to('info@fraboolpress.com')->send(new ConfirmProject($newLead));
        return redirect()->route('admin.projects.index')->with('message', 'Progetto aggiunto correttamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $form_data = $request->validated();
        $slug = Project::generateSlug($request->title, '-');
        $form_data['slug'] = $slug;
        if ($request->has('cover_image')) {
            //SECONDO CONTROLLO PER CANCELLARE IL FILE PRECEDENTE SE PRESENTE
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }
            $path = Storage::disk('public')->put('project_images', $request->cover_image);

            $form_data['cover_image'] = $path;
        }
        $project->update($form_data);
        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies);
        }
        return redirect()->route('admin.projects.index')->with('message', 'Progetto modificato corretamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        $project->technologies()->sync([]);
        return redirect()->route('admin.projects.index', compact('project'))->with('message', 'Progetto eliminato correttamente');
    }
}
