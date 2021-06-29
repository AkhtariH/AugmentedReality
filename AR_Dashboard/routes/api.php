<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ArtObjectController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ReviewController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('artobjects', [ArtObjectController::class, 'index']);
Route::get('simulator/{id}', [ArtObjectController::class, 'simulator']);
Route::get('reviews/{id}', [ReviewController::class, 'getReview']);
Route::post('reviews', [ReviewController::class, 'postReview']);
Route::post('login', [LoginController::class, 'index']);

Route::middleware('auth:api')->group( function () {
    Route::resource('bridges', BridgeController::class);
    Route::get('/user', function (Request $request){ return $request->user(); });
    Route::post('logout', [LoginController::class, 'logout']);
});