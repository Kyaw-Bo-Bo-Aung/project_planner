<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('projects', 'timesheets')->get();
        // $users->map(function($user) {
        //     $user['task_name'] = $user->timesheets;
        //     return $user;
        // });
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $user = User::create($request->all());
        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('projects')->find($id);
        if (!$user)
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        if (!$user)
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);

        $user->update($request->all());
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user)
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);

        $user->timesheets()->delete();
        $user->delete();
        return response()->json("Deleted successfully", Response::HTTP_OK);
    }
}
