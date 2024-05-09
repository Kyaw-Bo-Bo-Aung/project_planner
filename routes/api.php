<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TimesheetController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
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
});
