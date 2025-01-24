<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{
    APIAuthenticationController,
    TaskAPIController
};

/*
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
*/


// API Versioning
Route::prefix('v1')->group(function() {
    // Authentication
    Route::post('/login', [APIAuthenticationController::class, 'login']); // Public Route (No Authentication Required)
    Route::post('/logout', [APIAuthenticationController::class, 'logout'])->middleware('auth:sanctum'); // Protected Route (requires Authentication using Sanctum)    // Authenticate user using Laravel's default authentication middleware using the 'sanctum' guard (which is defined in config/sanctum.php)


    // Protected Routes (Require Authentication using Sanctum)    // Authenticate user using Laravel's default authentication middleware using the 'sanctum' guard (which is defined in config/sanctum.php)
    Route::middleware('auth:sanctum')->group(function() {
        // 'manager' Role routes
        Route::group(['middleware' => ['role:manager']], function() {
            Route::post('/tasks/create', [TaskAPIController::class, 'store']);
            Route::get('/tasks/{id}', [TaskAPIController::class, 'show']);

        });



        // 'user' Role routes


    });

});
