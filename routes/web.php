<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\VehicleController;
use App\Models\Vehicle;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::apiResource('vehicles', VehicleController::class);

Route::get('/vehicles', function () {
    $vehicles = Vehicle::with(['brand', 'fuelType'])->get();

    return view('vehicles', compact('vehicles'));
});
