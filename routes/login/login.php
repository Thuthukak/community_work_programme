<?php

use App\Http\Controllers\Core\Auth\User\LoginController;
use App\Http\Controllers\Core\Auth\RegisterController;



Route::get('login', [LoginController::class, 'show'])
    ->name('users.login.index');

Route::post('login', [LoginController::class, 'login'])
    ->name('users.login');
    // Registration Routes...
    Route::get('register', [RegisterController::class,'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class,'register']);