<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleServiceController;
use App\Http\Controllers\FuelingController;


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


Route::put(
    'vehicle-services/{vehicleService}',
    [VehicleServiceController::class, 'update']
)->name('vehicles.services.update');

Route::get(
    '/vehicles/{vehicle}/service-costs',
    [VehicleController::class, 'serviceCosts']
)->name('vehicles.service-costs');

Route::get(
    '/vehicles/{vehicle}/service-cost-summary',
    [VehicleController::class, 'serviceCostSummary']
)->name('vehicles.service-cost-summary');

Route::post(
    '/vehicles/{vehicle}/fuelings',
    [FuelingController::class, 'store']
)->name('vehicles.fuelings.store');

Route::put(
    '/fuelings/{fueling}',
    [FuelingController::class, 'update']
)->name('fuelings.update');

Route::delete(
    '/fuelings/{fueling}',
    [FuelingController::class, 'destroy']
)->name('fuelings.destroy');
