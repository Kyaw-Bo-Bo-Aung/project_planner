<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query();
        $search = $request->query();
        if(isset($search['name'])) {
            $query->where('name', 'like', '%'.$search['name'].'%');
        }

        if(isset($search['department'])) {
            $query->where('department', 'like', '%'.$search['department'].'%');
        }

        if(isset($search['start_date'])) {
            $query->whereDate('start_date', $search['start_date']);
        }

        if(isset($search['end_date'])) {
            $query->whereDate('end_date', $search['end_date']);
        }

        if(isset($search['status'])) {
            $query->where('status', $search['status']);
        }

        if(isset($search['username'])) {
            $query->whereHas('users', function ($q) use ($search){
                $q->where('first_name', 'like', '%'.$search['username'].'%')
                ->orWhere('last_name', 'like', '%'.$search['username'].'%');
            });
        }

        $projects = $query->with('users')->get();
        return response()->json($projects, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request)
    {
        DB::beginTransaction();

        try {
            $project = new Project();
            $project->name = $request->input('name');
            $project->department = $request->input('department');
            $project->start_date = $request->input('start_date');
            $project->end_date = $request->input('end_date');
            $project->status = $request->input('status');
            $project->save();
            $timesheets = $request->input('timesheets');
            if($timesheets) {
                $collect = collect($timesheets)->mapWithKeys(function ($t) {
                    return [$t['user_id'] => [
                        'task_name' => $t['task_name'],
                        'date' => $t['date'],
                        'hours' => $t['hours'],
                    ]];
                })->all();
                $project->users()->sync($collect);
            }
            DB::commit();

            return response()->json($project, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Error saving data.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return $project->load('users');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        DB::beginTransaction();

        try {
            $project->name = $request->input('name');
            $project->department = $request->input('department');
            $project->start_date = $request->input('start_date');
            $project->end_date = $request->input('end_date');
            $project->status = $request->input('status');
            $project->update();
            $timesheets = $request->input('timesheets');
            if($timesheets) {
                $collect = collect($timesheets)->mapWithKeys(function ($t) {
                    return [$t['user_id'] => [
                        'task_name' => $t['task_name'],
                        'date' => $t['date'],
                        'hours' => $t['hours'],
                    ]];
                })->all();
                $project->users()->sync($collect);
            }
            DB::commit();

            return response()->json($project, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Error saving data.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        DB::beginTransaction();
        try {
            $project->timesheets()->delete();
            $project->delete();
            DB::commit();            
            return response()->json("Deleted successfully", Response::HTTP_OK);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error deleting data.'], 500);
        }
    }
}
