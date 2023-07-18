<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ResponseToAdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//+
Route::prefix('auth')->middleware('api')->controller(AuthController::class)->group(function (){
    Route::post('register','register');
    Route::post('signup','signup');
    Route::post('logout','logout');
    Route::post('refresh','refresh');
    Route::middleware('admin')->post('docregister','docRegister');
    Route::post('update-user','updateUser');
    Route::middleware('doctor')->post('update-doctor','updateDoctor');//+
    Route::post('change-password','changePassword');
    Route::get('user','user');
});

Route::prefix('admin')->middleware('api')->controller(AdminController::class)->group(function (){
    Route::post('addCard','addCard');
    Route::post('updateCard','updateCard');
    Route::post('destroyCard','destroyCard');
    Route::get('cards','getCards');
    Route::post('card/{id}','getCard');
    Route::post('confirm','confirmResponse');//+
    Route::get('responses','getResponses');//+
    Route::get('not-completed-response','getNotCompletedResponse');//+
});

Route::prefix('admin-res')->middleware('api')->controller(ResponseToAdminController::class)->group(function (){
    Route::post('addResponse','addResponse');//+
    Route::post('destroyResponse','destroyResponse');//+
});

Route::prefix('doctor')->middleware('api')->controller(DoctorController::class)->group(function (){
    Route::post('confirm','confirmCard');
    Route::post('rating','getRating');//+
    Route::post('cards','getCardsByDoctorId');

    Route::get('doctors','getDoctors');//+

});

Route::prefix('client')->middleware('api')->controller(ClientController::class)->group(function (){
    Route::post('addRate','addRate');//-
    Route::post('updateRate','updateRate');//+
    Route::post('destroyRate','destroyRate');//+
    Route::post('cards','getCardsByClientId');
});



Route::get('test', function(Request $request){

    return response()->json(['msg'=>'ok']);
});
