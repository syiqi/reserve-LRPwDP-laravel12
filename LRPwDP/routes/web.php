<?php

use App\Http\Controllers\PerishableController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $countReservation = Reservation::where('status','success')->count();
    $countCustomer = User::where('role','customer')->count();
    $countSeller = User::where('role','seller')->count();
    return view('welcome', compact('countReservation','countCustomer','countSeller'));
});
Route::get('/home', [PerishableController::class, 'indexHome'])
    ->middleware(['auth', 'verified'])
    ->name('home');
Route::get('/dashboard', [PerishableController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
Route::get('/reservations/indexSeller', [ReservationController::class, 'indexSeller'])->name('reservations.indexSeller');
Route::resource('reservations', ReservationController::class);
Route::put('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
Route::put('/reservations/{reservation}/success', [ReservationController::class, 'success'])->name('reservations.success');
Route::get('/reservations/create/{id}', [ReservationController::class, 'createPerishableReservation'])->name('reservations.createPerishableReservation');


Route::resource('perishables', PerishableController::class);
Route::put('/perishables/{perishable}/unlist', [PerishableController::class, 'unlist'])->name('perishables.unlist');
Route::delete('/perishables/{perishable}/remove-image', [PerishableController::class, 'removeImage'])->name('perishables.removeImage');

