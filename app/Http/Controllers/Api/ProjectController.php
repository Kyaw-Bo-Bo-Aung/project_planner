<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Project::with('users')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request)
    {
        $project = Project::create($request->all());
        return response()->json($project, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with('users')->find($id);
        if (!$project)
            return response()->json(['error' => 'Project not found'], Response::HTTP_NOT_FOUND);
        
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, string $id)
    {
        $project = Project::find($id);
        if (!$project)
            return response()->json(['error' => 'Project not found'], Response::HTTP_NOT_FOUND);

        $project->update($request->all());
        return response()->json($project, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);
        if (!$project)
            return response()->json(['error' => 'Project not found'], Response::HTTP_NOT_FOUND);

        $project->timesheets()->delete();
        $project->delete();
        return response()->json("Deleted successfully", Response::HTTP_OK);
    }
}
