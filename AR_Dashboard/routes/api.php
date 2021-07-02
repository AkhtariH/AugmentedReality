<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ArtObjectController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SimulatorController;

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
Route::delete('simulator/{id}/delete', [SimulatorController::class, 'deleteSession']);