<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {

Route::get('/', function () {
    return view('pages.auth.auth-login');
});
});

Route::middleware(['auth'])->group(function () {
Route::get('/home', function () {
    return view('pages.dashboard');
})->name('home');

Route::resource('users', UserController::class);
Route::resource('companies', CompanyController::class);
Route::resource('attendances', AttendanceController::class);
// Route::get('attendances', [AttendanceController::class,'index'])->name('attendances.index');


});
// Route::get('/login', function () {
//     return view('page.auth.auth-login');
// });
