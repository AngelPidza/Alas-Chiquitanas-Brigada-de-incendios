<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // ! Si está autenticado pero es primera vez
        // if (!auth()->user()->first_login_completed) {
        //     return redirect('/welcome');
        // }

        // Usuario normal
        return redirect('/home');
    })->name('home');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get(
        '/dashboard',
        [App\Http\Controllers\HomeController::class, 'index']
    )->name('dashboard');
    Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');

    Route::resource('usuarios', App\Http\Controllers\UsuarioController::class)->except(['show']);
});
