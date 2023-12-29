<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
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

Route::group(['prefix'=>'tasks'], function (){
    // Fetch all tasks
    Route::get('/', [TaskController::class, 'index']);

    // Create a new task
    Route::post('/', [TaskController::class, 'store']);

    // Complete task
    Route::post('/complete/{task}', [TaskController::class, 'complete']);

    // Update a task
    Route::put('/{task}', [TaskController::class, 'update']);

    // Delete a task
    Route::delete('/{task}', [TaskController::class, 'destroy']);
});

Route::group(['prefix'=>'dashboard'], function (){
    Route::get('/statistics', [DashboardController::class, 'statistics']);
    Route::get('/tasks/near-due', [DashboardController::class, 'getTasksWithNearDueDate']);
});


