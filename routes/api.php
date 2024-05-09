<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TimesheetController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('users', UserController::class);
// Route::apiResource('projects', ProjectController::class);
// Route::apiResource('timesheets', TimesheetController::class);

// Users
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::post('/users/{user}/update', [UserController::class, 'update']);
Route::post('/users/{user}/delete', [UserController::class, 'destroy']);

// Projects
Route::get('/projects', [ProjectController::class, 'index']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::post('/projects/{project}/update', [ProjectController::class, 'update']);
Route::post('/projects/{project}/delete', [ProjectController::class, 'destroy']);

// Timesheets
Route::get('/timesheets', [TimesheetController::class, 'index']);
Route::post('/timesheets', [TimesheetController::class, 'store']);
Route::get('/timesheets/{timesheet}', [TimesheetController::class, 'show']);
Route::post('/timesheets/{timesheet}/update', [TimesheetController::class, 'update']);
Route::post('/timesheets/{timesheet}/delete', [TimesheetController::class, 'destroy']);

