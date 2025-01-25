<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{
    APIAuthenticationController,
    TaskAPIController
};



// API Versioning
Route::prefix('v1')->group(function() {
    // Authentication
    Route::post('/login', [APIAuthenticationController::class, 'login']); // Public Route (No Authentication Required)
    Route::post('/logout', [APIAuthenticationController::class, 'logout'])->middleware('auth:sanctum'); // Protected Route (requires Authentication using Sanctum)    // Authenticate user using Laravel's default authentication middleware using the 'sanctum' guard (which is defined in config/sanctum.php)


    // Protected Routes (Require Authentication using Sanctum)    // Authenticate user using Laravel's default authentication middleware using the 'sanctum' guard (which is defined in config/sanctum.php)
    Route::middleware('auth:sanctum')->group(function() {
        // 'manager' Role Routes
        Route::group(['middleware' => ['role:manager']], function() {
            Route::post('/tasks', [TaskAPIController::class, 'store']); // Create a task
            Route::get('/tasks/{id}', [TaskAPIController::class, 'show']); // Get a task by ID
            Route::get('/tasks', [TaskAPIController::class, 'index']); // Retrieve All/Filtered Tasks
            Route::put('/tasks/{id}', [TaskAPIController::class, 'update']); // Update a task by ID
        });


        // 'user' Role Routes
        Route::group(['middleware' => ['role:user']], function() {
            Route::put('/user/tasks/{id}/status', [TaskAPIController::class, 'updateStatus']); // Update the status of a task by ID
            Route::get('/user/tasks', [TaskAPIController::class, 'getUserAssignedTasks']); // Retrieve user's tasks
        });

    });

});
