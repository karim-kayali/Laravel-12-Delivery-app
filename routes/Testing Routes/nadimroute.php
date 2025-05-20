<?php

use App\Events\SuccessNotificationEvent;
use App\Http\Controllers\AdminControllers\AdminApplicationsController;
use App\Http\Controllers\AdminControllers\AdminCities;
use App\Http\Controllers\AdminControllers\AdminCRUD;
use App\Http\Controllers\AdminControllers\AdminReports;
use App\Http\Controllers\AdminControllers\AdminTrackDeliveries;
use App\Http\Controllers\DriverControllers\DriverReviewController;
use App\Http\Controllers\SharedController;
use App\Models\User;
use Chatify\Http\Controllers\MessagesController;
use Illuminate\Support\Facades\Route;

//Route::get("indexUser", [SharedController::class, "indexUser"])->name("indexUser");
//Route::get("indexAdmin", [SharedController::class, "indexAdmin"])->name("indexAdmin");
//Route::get("indexDriver", [SharedController::class, "indexDriver"])->name("indexDriver");
//
//Route::get("testNadim", function () {
//    return "route using nadimroute.php";
//})->name("testNadim");

Route::middleware(['adminMW'])->group(function () {

    Route::get("manageDriverView", [AdminApplicationsController::class, "manageDriverView"])->name("indexAdmin");
    Route::get("acceptDriver/{id}", [AdminApplicationsController::class, "acceptDriver"])->name("acceptDriver");
    Route::get("rejectDriver/{id}", [AdminApplicationsController::class, "rejectDriver"])->name("rejectDriver");
    Route::get("displayDriverDetails/{id}", [AdminApplicationsController::class, "displayDriverDetails"])->name("displayDriverDetails");
    Route::get("manageDriverViewDrop/{gotRegistered}", [AdminApplicationsController::class, "manageDriverViewDrop"])->name("manageDriverViewDrop");
    Route::get("manageDriverViewDrop/{gotRegistered}", [AdminApplicationsController::class, "manageDriverViewDrop"])->name("manageDriverViewDrop");
    Route::get("displayAdminProfile/{id}", [AdminCRUD::class, "displayAdminProfile"])->name("displayAdminProfile");
    Route::get("turnOnEdit/{id}", [AdminCRUD::class, "turnOnEdit"])->name("turnOnEdit");
    Route::put("editAdminProfile/{id}", [AdminCRUD::class, "editAdminProfile"])->name("editAdminProfile");

    Route::get("adminTrackDeliveriesView", [AdminTrackDeliveries::class, "adminTrackDeliveriesView"])->name("adminTrackDeliveriesView");
    Route::get("adminTrackDeliveriesViewDrop/{requestStatus}", [AdminTrackDeliveries::class, "adminTrackDeliveriesViewDrop"])->name("adminTrackDeliveriesViewDrop");
    Route::get("displayDeliveryDetails/{id}", [AdminTrackDeliveries::class, "displayDeliveryDetails"])->name("displayDeliveryDetails");
    Route::get("AdminCitiesView", [AdminCities::class, "AdminCitiesView"])->name("AdminCitiesView");
    Route::get("AdminCreateCityView", [AdminCities::class, "AdminCreateCityView"])->name("AdminCreateCityView");
    Route::post("AdminCreateCity", [AdminCities::class, "AdminCreateCity"])->name("AdminCreateCity");
    Route::get("AdminEditCityView/{id}", [AdminCities::class, "AdminEditCityView"])->name("AdminEditCityView");
    Route::put("AdminEditCity/{id}", [AdminCities::class, "AdminEditCity"])->name("AdminEditCity");
    Route::delete("AdminDeleteCity/{id}", [AdminCities::class, "AdminDeleteCity"])->name("AdminDeleteCity");
    Route::get("AdminReportsView", [AdminReports::class, "AdminReportsView"])->name("AdminReportsView");
    Route::get("AdminReportsViewDrop/{roleName}", [AdminReports::class, "AdminReportsViewDrop"])->name("AdminReportsViewDrop");
    Route::get("userDetailedReport/{id}", [AdminReports::class, "userDetailedReport"])->name("userDetailedReport");
    Route::get("driverDetailedReport/{id}", [AdminReports::class, "driverDetailedReport"])->name("driverDetailedReport");


});
Route::get("logout", [AdminCRUD::class, "logout"])->name("logout");





Route::middleware(['eitherCorD'])->group(function () {

    Route::get("getMaps/{id}", [AdminApplicationsController::class, "getMaps"])->name("getMaps");
    Route::get('/chatify/{id}/{deliveryid}', [MessagesController::class, 'index'])
        ->name('chatify.delivery');
//    Route::get("ContactUsSection", [SharedController::class, "ContactUs"])->name("ContactUsSection");

});

Route::get("AboutUsSection", [SharedController::class, "AboutUs"])->name("AboutUsSection");


Route::middleware(['driverMW'])->group(function () {
    Route::get("viewOwnReviews", [DriverReviewController::class, "viewOwnReviews"])->name("viewOwnReviews");

});

use App\Events\TestPusherEvent;


//Route::get('/pusher-test', function () {
//    $users = User::all();
//    return view('TestingNotificationView', compact('users'));
//});

//Route::get('/trigger-test-event', function () {
//    broadcast(new TestPusherEvent('Hello from Laravel and Pusher!'));
//    return 'Event broadcasted';
//});

Route::get('/trigger-success-event', function () {
    broadcast(new SuccessNotificationEvent('Your delivery Request has been sent to the driver !'));
    return 'Event broadcasted';
});

