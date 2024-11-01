<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\User\BrandsController;
use App\Http\Controllers\BrandsAuthController;

use App\Http\Controllers\Admin\DevicesAdminController;
use App\Http\Controllers\DevicesController;

use App\Http\Controllers\Pro\CartProController;

// Route::get('/', function () {
//   return view('welcome');
// });

Route::view('/', 'index')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
  // сторінка на яку переходить зареєстрований та авторізований(залогінений) користувач
  Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

  // в браузере писати user/brands а в роутах писати user.brands
  Route::prefix('admin')->as('admin.')->group(function(){
    Route::resource('devices', DevicesAdminController::class)->parameters(['devices' => 'id']);

    // Route::get('devices/{id}/addToCart', [DevicesAdminController::class, 'addToCart'])->name('devices.addToCart');

    // Route::get('devices', [DevicesAdminController::class, 'index'])->name('devices.index');
    // Route::get('devices/create', [DevicesAdminController::class, 'create'])->name('devices.create');
    // Route::get('devices/{device}', [DevicesAdminController::class, 'show'])->name('devices.show');  

        Route::get('devices', [DevicesAdminController::class, 'index'])->name('devices.index');

        
});

  // // в браузере писати user/brands а в роутах писати user.brands
  // Route::prefix('pro')->as('pro.')->group(function(){
  //   Route::controller(CartProController::class)
  //   ->prefix('cart')
  //   ->group(function(){
  //     Route::get('/', 'index')->name('cart');
  //     Route::post('/{device}/add', 'add')->name('cart.add');
  //     Route::post('/{item}/quantity', 'quantity')->name('cart.quantity');
  //     Route::delete('/{item}/delete', 'delete')->name('cart.delete');
  //     Route::delete('/truncate', 'truncate')->name('cart.truncate');
  //   });

    // Route::get('cart', [CartProController::class, 'index'])->name('cart.index');
    // Route::get('cart', [CartProController::class, 'add'])->name('cart.add');
    // Route::get('cart', [CartProController::class, 'quantity'])->name('cart.quantity');
    // Route::get('cart', [CartProController::class, 'delete'])->name('cart.delete');

    // Route::get('devices', [DevicesAdminController::class, 'index'])->name('devices.index');
    // Route::get('devices/create', [DevicesAdminController::class, 'create'])->name('devices.create');
    // Route::get('devices/{device}', [DevicesAdminController::class, 'show'])->name('devices.show');  

// });

  Route::resource('devices', DevicesController::class);
 

  // Route::get('devices', [DevicesController::class, 'index'])->name('devices');
  // Route::get('devices/create', [DevicesController::class, 'create'])->name('devices.create');
  // Route::post('devices', [DevicesController::class, 'store'])->name('devices.store');
  // Route::get('devices/{device}', [DevicesController::class, 'show'])->name('devices.show');
  // Route::get('devices/{device}/edit', [DevicesController::class, 'edit'])->name('devices.edit');
  // Route::put('devices/{device}', [DevicesController::class, 'update'])->name('devices.update');
  // Route::delete('devices/{device}', [DevicesController::class, 'destroy'])->name('devices.destroys');


  Route::resource('brands', BrandsAuthController::class)->parameters(['brands' => 'id']);

    // Route::resource('devices', DevicesAdminController::class)->parameters(['devices' => 'id']);

  // // в браузере писати user/brands а в роутах писати user.brands
  // Route::prefix('user')->as('user.')->group(function(){
  //     Route::get('brands', [BrandsController::class, 'index'])->name('brands');
  // });

});


Route::middleware('guest')->group(function () {
  Route::get('register', [UserController::class, 'create'])->name('register');
  Route::post('register', [UserController::class, 'store'])->name('user.store');

  Route::get('login', [UserController::class, 'login'])->name('login');
  Route::post('login', [UserController::class, 'loginAuth'])->name('login.auth');

  // відновлення пароля
  Route::get('forgot-password', function () {
    return view('user.forgot-password');
  })->name('password.request');

  Route::post('forgot-password', [UserController::class, 'forgotPasswordStore'])->name('password.email')->middleware('throttle:3,1');

  Route::get('reset-password/{token}', function (string $token) {
    return view('user.reset-password', ['token' => $token]);
  })->name('password.reset');

  Route::post('reset-password', [UserController::class,'resetPasswordUpdate'])->name('password.update');

});


Route::middleware('auth')->group(function () { Route::get('logout', [UserController::class, 'logout'])->name('logout');

  // маршрути для Реєстрації / Авторізації
  // 1 відповідає за повідомлення на сторінці
  Route::get('verify-email', function () {
    return view('user.verify-email');
  })->name('verification.notice');

  // 2 відповідає за підтверження користувача при переході по посиланню
  Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard');
  })->middleware('signed')->name('verification.verify');

  // 3 відповідає за повторне відправлення листа
  Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Посилання для підтвердження надіслано!');
  })->middleware('throttle:3,1')->name('verification.send');
});


// Якщо сторінки не існує, то перехід на наприклад сторінку 404
// Route::fallback(function(){
//   return 'Fallback';
// });

