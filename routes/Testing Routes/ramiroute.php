<?php

use App\Http\Controllers\SharedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverControllers\DefinePricingController;
use App\Http\Controllers\DriverControllers\DriverProfileController;
use App\Http\Controllers\DriverControllers\DeliveryRequestController;

Route::get("testRami", function () {
    return "route using ramiroute.php";
})->name("testRami");


Route::middleware(['driverMW'])->group(function () {

//    Route::get("indexDriver", [SharedController::class, "indexDriver"])->name("indexDriver");
// Route to show the driver update form
//Route::get('/driver/update', [DefinePricingController::class, 'showUpdateForm'])->name('driver.update.form');
// Route to handle the driver info update form submission (using PUT method)
//Route::put('/driver/update', [DefinePricingController::class, 'updateDriverInfo'])->name('driver.update.submit');
    Route::get("displayDriverProfile/{id}", [DriverProfileController::class, "displayDriverProfile"])->name("displayDriverProfile");
    Route::get("DriverTurnOnEdit/{id}", [DriverProfileController::class, "DriverTurnOnEdit"])->name("DriverTurnOnEdit");
    Route::put("editDriverProfile/{id}", [DriverProfileController::class, "editDriverProfile"])->name("editDriverProfile");
    Route::post('/deliveries/{id}/accept', [DeliveryRequestController::class, 'acceptDelivery'])->name('deliveries.accept');
    Route::post('/deliveries/{id}/reject', [DeliveryRequestController::class, 'rejectDelivery'])->name('deliveries.reject');
    Route::get('/deliveries/{id}', [DeliveryRequestController::class, 'showDeliveryDetails'])->name('deliveries.details');
});
Route::get('/deliveries/pending', [DeliveryRequestController::class, 'showPendingDeliveries'])->name('deliveries.pending');

Route::get('/rejectDriverPage', [DeliveryRequestController::class, 'RejectedDriverPageFunction']);
Route::get('/pendingDriverPage', [DeliveryRequestController::class, 'PendingDriverPageFunction']);

