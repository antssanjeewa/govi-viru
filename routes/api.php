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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');


Route::group(['middleware' => 'auth:api'], function(){

    Route::post('details', 'API\UserController@details');
    Route::get('user', 'API\UserController@getUser');

    Route::post('registerFarmer', 'API\UserController@farmerRegister');

    Route::post('vegetableList', 'API\VegetableController@createVegeList');
    Route::apiResource('vegetable', 'API\VegetableController');
});