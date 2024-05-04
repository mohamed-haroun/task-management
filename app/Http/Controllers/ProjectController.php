<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(['projects' => Project::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $request->validated();

        try {
            $project = Project::create([
                'name' => $request->post('name'),
                'description' => $request->post('description'),
                'slug' => Str::slug($request->post('name') . '-' . Str::random(10)),
                'start_date' => $request->post('start_date'),
                'end_date' => $request->post('end_date'),
            ]);

            auth()->user()->projects()->attach($project, ['role' => 'manager']);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }

        return $this->success(['message' => 'Project created successfully']);

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return $this->success(['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $request->validate([]);

        try {
            $project->update($request->all());
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }

        return $this->success(['message' => 'Project updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return $this->success(['message' => 'Project deleted successfully']);
    }
}
