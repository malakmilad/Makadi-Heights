<?php

use Illuminate\Support\Facades\Route;
use App\Models\Payment;
use App\Models\Rate;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/test', function () {
    $payment  = Payment::find(60);
    // dd($payment->down_payment * $payment->currency->rate);
    $client = new Client([
        'base_uri' => config('app.database_url'),
    ]);
    $response = $client
        ->get(config('app.database_url').'/zones')
        ->getBody();

    $obj = json_decode($response);

    foreach ($obj as $zone) {
        if ($zone->zoneName == $payment->zone) {
            foreach ($zone->building_types as $building_type) {
                if ($building_type->unitName == $payment->building_type) {
                    // dd($building_type->unitName);
                    $will_use_building_type = $building_type;
                    $will_use_zone = $zone;
                    break;
                }
            }
        }
    }
    Mail::to(["eyad-mohd@hotmail.com"])->send(
        new \App\Mail\PaymentSuccessToAdmin(
            $payment,
            $will_use_zone,
            $will_use_building_type,
            // $will_use_unit
        )
    );
});
*/


Route::group(
    [
        'middleware' => ['auth'],
    ],
    function () {

        // Route::get('/', function () {
        //     return view('dashboard');
        // })->name('dashboard');
        Route::get('/', [App\Http\Controllers\UserController::class, 'showWhatsNew'])->name('dashboard');
        Route::get('/unset-cookie', [App\Http\Controllers\UserController::class, 'unSetCookie'])->name('cookie.unset');

        Route::group(['middleware' => ['can:payments.show']], function () {
            Route::get('/payments', [App\Http\Controllers\PaymentController::class, 'index'])->name('payments');
            Route::get('/payments/search', [App\Http\Controllers\PaymentController::class, 'searchPayments'])->name('payments-search');
            Route::get('/payment-search-unit',[App\Http\Controllers\PaymentController::class, 'searchPaymentsUnit'])->name('payment-search-unit');
            Route::get('/show/{id}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
            Route::get('download-as-pdf/{id}',[App\Http\Controllers\PaymentController::class,'DownloadAsPdf'])->name('pdf');
        });

        Route::group(['middleware' => ['can:payments.create']], function () {
            Route::get('/create', [App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
            Route::post('/store', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');

            Route::get('/unit-unique-search-page', [App\Http\Controllers\PaymentController::class, 'searchUnitUniqueReferencePage'])->name('units.search.page');

            Route::get('/unit-unique-search', [App\Http\Controllers\PaymentController::class, 'searchUnitUniqueReference'])->name('units.search');
        });

        Route::group(['middleware' => ['can:payments.edit']], function () {
            Route::get('/edit/{id}', [App\Http\Controllers\PaymentController::class, 'edit'])->name('payments.edit');
            Route::put('/update/{id}', [App\Http\Controllers\PaymentController::class, 'update'])->name('payments.update');
        });

        Route::group(['middleware' => ['can:payments.delete']], function () {
            Route::delete('/delete/{id}', [App\Http\Controllers\PaymentController::class, 'destroy'])->name('payments.delete');
        });

        Route::group(['middleware' => ['can:faqs.show']], function () {
            Route::get('/faqs', [App\Http\Controllers\FaqController::class, 'index'])->name('faqs');
            Route::get('/faqs/search', [App\Http\Controllers\FaqController::class, 'searchfaqs'])->name('faqs-search');
            Route::get('/faqs/show/{id}', [App\Http\Controllers\FaqController::class, 'show'])->name('faqs.show');
        });

        Route::group(['middleware' => ['can:faqs.create']], function () {
            Route::get('/faqs/create', [App\Http\Controllers\FaqController::class, 'create'])->name('faqs.create');
            Route::post('/faqs/store', [App\Http\Controllers\FaqController::class, 'store'])->name('faqs.store');
        });

        Route::group(['middleware' => ['can:faqs.edit']], function () {
            Route::get('/faqs/edit/{id}', [App\Http\Controllers\FaqController::class, 'edit'])->name('faqs.edit');
            Route::put('/faqs/update/{id}', [App\Http\Controllers\FaqController::class, 'update'])->name('faqs.update');
        });

        Route::group(['middleware' => ['can:faqs.delete']], function () {
            Route::delete('/faqs/delete/{id}', [App\Http\Controllers\FaqController::class, 'destroy'])->name('faqs.delete');
        });

        Route::group(['middleware' => ['can:users.create']], function () {
            Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
            Route::get('/users/{id}/show', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
            Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
            Route::post('/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
            Route::get('/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
            Route::put('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.delete');
        });

        Route::group(['middleware' => ['can:payments.export']], function () {
            Route::get('/payments/export/', [App\Http\Controllers\PaymentController::class, 'export'])->name('payments.export');
        });


        Route::group(['middleware' => ['can:roles']], function () {
            Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles');
            Route::get('/roles/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
            Route::put('/roles/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
            Route::delete('/roles/{id}/delete', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.delete');
        });

        Route::group(['middleware' => ['can:rates.edit']], function () {
            Route::get('/rates', [App\Http\Controllers\RatesController::class, 'index'])->name('rates');
            Route::get('/rates/edit/{id}', [App\Http\Controllers\RatesController::class, 'edit'])->name('rates.edit');
            Route::put('/rate/update/{id}', [App\Http\Controllers\RatesController::class, 'update'])->name('rates.update');
        });


        Route::post('/send-payment-link/{id}', [App\Http\Controllers\PaymentController::class, 'sendPaymentLink'])->name('payments.send');

        Route::get('/get-receipt/{hashed}', [App\Http\Controllers\PaymentController::class, 'getReceipt'])->name('receipt.get');
        Route::get('expired-payment',[App\Http\Controllers\PaymentController::class,'get_expired_payment'])->name('payments.expired');
        Route::get('restore/{id}',[App\Http\Controllers\PaymentController::class,'restore'])->name('restore');
        Route::delete('force/{id}',[App\Http\Controllers\PaymentController::class,'ForceDelete'])->name('force');
    }
);

require __DIR__ . '/auth.php';
