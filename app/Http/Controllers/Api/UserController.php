<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        $search = $request->query();
        if(isset($search['first_name'])) {
            $query->where('first_name', 'like', '%'.$search['first_name'].'%');
        }

        if(isset($search['last_name'])) {
            $query->where('last_name', 'like', '%'.$search['last_name'].'%');
        }

        if(isset($search['date_of_birth'])) {
            $query->whereDate('date_of_birth', $search['date_of_birth']);
        }

        if(isset($search['gender'])) {
            $query->where('gender', $search['gender']);
        }

        if(isset($search['email'])) {
            $query->where('email', 'like', '%'.$search['email'].'%');
        }

        $users = $query->with('projects')->get();
        return response()->json($users, Response::HTTP_OK);
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
    public function show(User $user)
    {
        return $user->load('projects');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->timesheets()->delete();
            $user->delete();
            DB::commit();            
            return response()->json("Deleted successfully", Response::HTTP_OK);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error deleting data.'], 500);
        }
    }
}
