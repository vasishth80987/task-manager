<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirect the root URL to the login page
Route::redirect('/', '/login');

// Include authentication routes
require __DIR__.'/auth.php';

// Group of routes that require user authentication and email verification
Route::middleware(['auth', 'verified'])->group(function () {
    // Route to view the dashboard page
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    // Route to view the profile page
    Route::view('profile', 'profile')
        ->name('profile');

    // Resource routes for UserController, excluding the 'show' method
    Route::resource('user', App\Http\Controllers\UserController::class)->except('show');

    // Resource routes for TaskController
    Route::resource('task', App\Http\Controllers\TaskController::class);

    // Resource routes for TeamController, excluding the 'show' method
    Route::resource('team', App\Http\Controllers\TeamController::class)->except('show');
});
