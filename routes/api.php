<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

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

// API route for user login and token generation
Route::post('/login', function (Illuminate\Http\Request $request) {
    // Check if the user is already logged in
    if (auth()->user()) {
        // Get user roles and permissions
        $roles = auth()->user()->getRoleNames()->toArray();
        $abilities = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        // Create or retrieve existing token
        $token = auth()->user()->tokens()->first()->token ?? auth()->user()->createToken('apiToken', $abilities)->plainTextToken;
        return view('api', compact('token'));
    } else {
        // Authenticate user based on email and password
        if (!\Illuminate\Support\Facades\Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        // Fetch authenticated user and create a new token
        $user = \App\Models\User::where('email', $request['email'])->firstOrFail();
        $roles = $user->getRoleNames()->toArray();
        $abilities = $user->getAllPermissions()->pluck('name')->toArray();
        $token = $user->createToken('apiToken', $abilities)->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
});

// use Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    // Fetch current authenticated user's data
    Route::get('/user', function (Request $request) {
        return $request->user()->toJson();
    });

    // API resource routes for managing tasks
    Route::apiResource('tasks', TaskController::class);
});
