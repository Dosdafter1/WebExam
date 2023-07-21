<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResponseToAdminController;
use App\Http\Controllers\TestController;

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
Route::prefix('auth')->controller(AuthController::class)->group(function (){
    Route::put('register','register');
    Route::post('login','login');
    Route::post('logout','logout');
    Route::post('refresh','refresh');
    Route::put('docregister','docRegister')->middleware('admin');
    Route::put('update-user','updateUser');
    Route::middleware('doctor')->post('update-doctor','updateDoctor');//+
    Route::put('change-password','changePassword');
    Route::get('user','user');
});

Route::prefix('admin')->controller(AdminController::class)->group(function (){
    Route::post('addCard','addCard');
    Route::put('updateCard','updateCard');
    Route::delete('destroyCard/{id}','destroyCard');
    Route::get('cards','getCards');
    Route::post('card/{id}','getCard');
    Route::put('confirm','confirmResponse');//+
    Route::get('responses','getResponses');//+
    Route::get('not-completed-response','getNotCompletedResponse');//+
});

Route::prefix('admin-res')->controller(ResponseToAdminController::class)->group(function (){
    Route::post('addResponse','addResponse');//+
    Route::delete('destroyResponse/{id}','destroyResponse');//+
});

Route::prefix('doctor')->controller(DoctorController::class)->group(function (){
    Route::put('confirm','confirmCard');
    Route::post('rating','getRating');//+
    Route::get('cards','getCardsByDoctorId');
    Route::get('doctors','getDoctors');//+
    Route::get('clients','getClients');
});

Route::prefix('client')->controller(ClientController::class)->group(function (){
    Route::post('add-rate','addRate');//-
    Route::put('update-rate','updateRate');//+
    Route::delete('destroy-rate','destroyRate');//+
    Route::get('cards','getCardsByClientId');
    
});


/*
Route::get('test', function(){

    return response()->json('ok');
});
Route::post('testP', function(Request $request){
    $em = $request->json('email');
    $pas = $request->json('password');
    $res = [$em,$pas];
    return response()->json($res);
});
Route::prefix('test')->controller(TestController::class)->group(function (){
    Route::post('testC','testC');//-
    Route::get('testL','testL');
    Route::get('login','login');
});
*/