<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleServiceController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::post('/login', [LoginController::class, 'login'])
    ->name('login');


Route::resource('vehicles', VehicleController::class);

Route::post(
    'vehicles/{vehicle}/services',
    [VehicleServiceController::class, 'store']
)->name('vehicles.services.store');

Route::delete(
    'vehicle-services/{vehicleService}',
    [VehicleServiceController::class, 'destroy']
)->name('vehicles.services.destroy');
