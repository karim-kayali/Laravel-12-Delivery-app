<?php

use App\Http\Controllers\SharedController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', 'auth/login');

Route::get('/test', function () {
    return "test";
});

//Route::get("index", [SharedController::class, "index"]);

// Code in order to link all the files in "Testing Routes" to the web.php file
// (to ignore conflicts on git)
// So now all the files in "Testing Routes" folder are acting as a seperate web.php file (route file)
foreach (glob(__DIR__ . '/Testing Routes/*.php') as $featureRouteFile) {
    require $featureRouteFile;
}
