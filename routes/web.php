<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/login');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

    #create api token for user
    Route::post('/api/login', function (\Illuminate\Support\Facades\Request $request) {
        $token = auth()->user()->createToken('apiToken');
        return view('api', compact('token'));
    });

    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::resource('user', App\Http\Controllers\UserController::class);

    Route::get('task/save', [App\Http\Controllers\TaskController::class, 'save']);
    Route::resource('task', App\Http\Controllers\TaskController::class);

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
});







Route::resource('user', App\Http\Controllers\UserController::class)->only('store', 'update');

Route::resource('task', App\Http\Controllers\TaskController::class)->only('store', 'update');


Route::resource('user', App\Http\Controllers\UserController::class);

Route::resource('task', App\Http\Controllers\TaskController::class);

Route::resource('team', App\Http\Controllers\TeamController::class);
