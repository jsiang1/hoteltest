<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

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

Route::get('/', function () {
    return view('home/index');
});
Route::get("index",function(){
    return view("home/index");
});
Route::get("rooms",function(){
    return view("home/rooms");
});
Route::get("reservations",function(){
    return view("home/reservations");
});
Route::get("singleroom",function(){
    return view("home/singleroom");
});
Route::get("deluxeroom",function(){
    return view("home/deluxeroom");
});
Route::get("familyroom",function(){
    return view("home/familyroom");
});

// Route to show the reservation form
Route::get('/reservations', [ReservationController::class, 'showForm'])->name('reservations_form');

// Route to handle the form submission
Route::post('/reservations', [ReservationController::class, 'submitForm'])->name('submit_reservation');

// Route to handle the payment
Route::get('/payment', function () {
    // This is just a placeholder route for the payment page
    return view('payment');
})->name('payment');

// Route to make reservation after payment is completed
Route::post('/make-reservation', [ReservationController::class, 'makeReservation'])->name('make_reservation');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/employee/dashboard', function () {
    return view('employee.dashboard');
})->middleware(['auth:employee', 'verified'])->name('employee.dashboard');

require __DIR__.'/employeeauth.php';