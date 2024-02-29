<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Requests\ProjectStoreRequest;

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
        return view('dashboard', compact('projects')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStoreRequest $request)
    {

        $data = $request->all();

        $new_project = new Project();

        if ($request->hasFile('project_image')) {
            $img_path = Storage::disk('public')->put('projects_image', $data['project_image']);
            $data['project_image'] = $img_path;
        }


        $new_project->fill($data);
        
        $new_project->save();

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    { 
        return view('show', compact('project'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $error_message = '';

        if (!empty($request->all())) {
            $messages = $request->all();
            $error_message = $messages['error_message'];
        }

        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types', 'error_message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $data = $request->all();

        
        if ($request->hasFile('project_image')) {
            if ($project->project_image != null) {
                Storage::disk('public')->delete($project->project_image);
            }
            $img_path = Storage::disk('public')->put('projects_image', $data['project_image']);
            $data['project_image'] = $img_path;
        }
        
        $project->update($data);
        

        return redirect()->route('show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->cover_image != null) {
            Storage::disk('public')->delete($project->cover_image);
        }

        $project->delete();

        return redirect()->route('dashboard');
    }
}
