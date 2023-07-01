<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(
//     [
//         'middleware' => ['auth:sanctum'],
//     ],
//     function () {
    Route::put('/payment/{hashed}/status', [App\Http\Controllers\ApiController::class, 'updateStatus'])->name('payments.update-status');
    Route::get('/payment/{hashed}', [App\Http\Controllers\ApiController::class, 'getPayment'])->name('payments');
    Route::get('/faqs', [App\Http\Controllers\ApiController::class, 'getFaqs'])->name('payments');

    Route::get('/create-session', [App\Http\Controllers\PaymentController::class, 'createSession'])->name('session.create');

    Route::get('/rate/{id}', [App\Http\Controllers\RatesController::class, 'getRate'])->name('rate.get');
    Route::get('/rates', [App\Http\Controllers\RatesController::class, 'getRates'])->name('rates.get');

    Route::get('/send-sms', [App\Http\Controllers\PaymentController::class, 'sendSms'])->name('sms');

    Route::get('/test', [App\Http\Controllers\ApiController::class, 'test'])->name('test');


    // }
// );
