<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheet\CreateTimesheetRequest;
use App\Http\Requests\Timesheet\UpdateTimesheetRequest;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Timesheet::with('user', 'project')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTimesheetRequest $request)
    {
        $timesheet = new Timesheet();
        $timesheet->task_name = $request->input('task_name');
        $timesheet->date = $request->input('date');
        $timesheet->hours = $request->input('hours');
        $timesheet->user_id = $request->input('user_id');
        $timesheet->project_id = $request->input('project_id');
        $timesheet->save();

        return response()->json($timesheet, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $timesheet = Timesheet::with('user', 'project')->find($id);
        if (!$timesheet)
            return response()->json(['error' => 'Timesheet not found'], Response::HTTP_NOT_FOUND);

        return response()->json($timesheet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimesheetRequest $request, string $id)
    {
        $timesheet = Timesheet::find($id);
        if (!$timesheet)
            return response()->json(['error' => 'Timesheet not found'], Response::HTTP_NOT_FOUND);

        $timesheet->task_name = $request->input('task_name');
        $timesheet->date = $request->input('date');
        $timesheet->hours = $request->input('hours');
        $timesheet->user_id = $request->input('user_id');
        $timesheet->project_id = $request->input('project_id');
        $timesheet->update();
        return response()->json($timesheet, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timesheet = Timesheet::find($id);
        if (!$timesheet)
            return response()->json(['error' => 'timesheet not found'], Response::HTTP_NOT_FOUND);

        $timesheet->delete();
        return response()->json("Deleted successfully", Response::HTTP_OK);
    }
}
