<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoomController;

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

Route::get("review",function(){
    return view("home/review");
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
Route::get("result",function(){
    return view("/home/result");
});
Route::get('/rooms', [RoomController::class, 'showRooms']);
Route::get('/singleroom', [RoomController::class, 'showSingleRoom']);
Route::get('/deluxeroom', [RoomController::class, 'showDeluxeRoom']);
Route::get('/familyroom', [RoomController::class, 'showFamilyRoom']);
Route::get('/review', [ReviewController::class, 'index'])->name('home.review');
Route::get('/filterresult', [ReviewController::class, 'filter'])->name('reviews.filter');

// Route to show the reservation form
Route::get('/reservations', [ReservationController::class, 'showForm'])->name('reservations_form');

// Route to handle the form submission
Route::post('/submit-reservation', [ReservationController::class, 'submitReservation'])->name('submit_reservation');

// Route to display the payment form
Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment_page');

// Route to process the payment
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('process_payment');

Route::get('show_session_data',function(){
    dd(session()->all());
});

Route::get('/cancel-payment', [PaymentController::class, 'cancelPayment'])->name('cancel_payment');

// Route to make reservation after payment is completed
Route::post('/make-reservation', [ReservationController::class, 'makeReservation'])->name('make_reservation');

Route::get('/make-reservation', [ReservationController::class, 'makeReservation'])->name('make_reservation');

Route::post('/insert-payment', [PaymentController::class, 'insertPayment'])->name('insert_payment');

Route::get('/insert-payment', [PaymentController::class, 'insertPayment'])->name('insert_payment');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile.home', [ProfileController::class, 'home'])->name('profile.home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    Route::get('/profile/review/{reservationID}', [ReviewController::class, 'showReviewForm'])->name('profile.writereview');
    Route::post('/submit-review', [ReviewController::class, 'submitReview'])->name('submit_review');
});

require __DIR__.'/auth.php';

Route::middleware('auth:employee')->group(function () {
Route::get('/employee/dashboard', function () {return view('employee.dashboard');})->name('employee.dashboard');
Route::get('/employee/dashboard', [ReservationController::class, 'index'])->name('employee.dashboard');
Route::get('/employee/reviewNotifi', function () {return view('employee.reviewNotifi');})->name('employee.reviewNotifi');
Route::get('/employee/reviewNotifi', [NotificationController::class, 'index'])->name('employee.reviewNotifi');
Route::get('/employee/room', function () {return view('employee.room');})->name('employee.room');
Route::get('/employee/room', [RoomController::class, 'index'])->name('employee.room.index');
Route::get('/employee/editroom/{room}', [RoomController::class, 'edit'])->name('employee.room.edit');
Route::put('/employee/editroom/{room}', [RoomController::class, 'update'])->name('employee.room.update');
Route::get('/employee/successedit', function () {return view('employee.successedit');})->name('employee.successedit');
Route::get('/employee/paymentlist', [PaymentController::class, 'index'])->name('employee.paymentlist');
}); 

require __DIR__.'/employeeauth.php';