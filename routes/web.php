<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsAdvisoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sms-dashboard', [SmsAdvisoryController::class, 'index']);
Route::post('/sms-dashboard', [SmsAdvisoryController::class, 'store'])->name('sms.store');
Route::view('/privacy', 'privacy');


