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

    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::resource('user', App\Http\Controllers\UserController::class);

    Route::get('task/save', [App\Http\Controllers\TaskController::class, 'save']);
    Route::resource('task', App\Http\Controllers\TaskController::class);

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
});
