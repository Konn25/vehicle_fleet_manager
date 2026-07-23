<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\VehicleController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::post('/login', [LoginController::class, 'login'])
    ->name('login');


Route::resource('vehicles', VehicleController::class);
