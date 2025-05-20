<?php

use App\Http\Controllers\ClientControllers;

use App\Http\Controllers\ClientControllers\DeliveryCalendarController;
use Illuminate\Support\Facades\Route;


use Chatify\Http\Controllers\MessagesController;


Route::get("testKarim", function () {
    return "route using karimroute.php";
})->name("testKarim");

Route::middleware(['eitherCorD'])->group(function () {
    Route::get('/calendar', [DeliveryCalendarController::class, 'index'])->name('calendar');
    Route::get('/fetch-deliveries', [DeliveryCalendarController::class, 'fetchDeliveries'])->name('fetchingDeliveries');

});

Route::middleware(['clientMW'])->group(function () {

    Route::get('DeliveryForm', [ClientControllers\DeliveryCreationController::class, 'DeliveryForm'])->name('DeliveryForm') ;

    Route::post('FilterDrivers', [ClientControllers\DeliveryCreationController::class, 'FilterDrivers'])->name('FilterDrivers');



    Route::get('/driverssearch', [ClientControllers\DeliveryCreationController::class, 'searchDrivers'])->name('driverssearch');

    Route::get('PaymentPage', [ClientControllers\DeliveryCreationController::class, 'PaymentPage'])->name('PaymentPage') ;

    Route::post('/stripe-session', [ClientControllers\DeliveryCreationController::class,  'createSession'])->name('stripe.session');

    Route::post('/coinbase-session', [ClientControllers\DeliveryCreationController::class, 'createCoinbaseSession'])->name('coinbase.session');

    Route::get('SuccessfulPayment', [ClientControllers\DeliveryCreationController::class, 'Success'])->name('Success') ;


//    Route::get('Home', [ClientControllers\DeliveryCreationController::class, 'ReturnHomePage'])->name('ReturnHomePage') ;


    Route::get('PendingDeliveries', [ClientControllers\ClientDeliveryController::class, 'ShowPendingDeliveries'])->name('PendingDeliveries') ;

    Route::get('test1', [ClientControllers\DeliveryCreationController::class, 'test1'])->name('test1') ;








});
Route::post('ChangeStatusToComplete/{id}',[\App\Classes\LoyaltyRules::class,'completeDelivery'])->name('ChangeStatusToComplete')->middleware('driverMW');
Route::get('/get-delivery-status/{id}', [\App\Classes\LoyaltyRules::class, 'getDeliveryStatus'])->name('getDeliveryStatus')->middleware('clientMW');




Route::get('/support-chat/{id?}', [MessagesController::class, 'index2'])->name('support.chat')->middleware('eitherDorA');


