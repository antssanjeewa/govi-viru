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
    Route::get('users/searchFarmer', 'API\UserController@searchFarmer');
    Route::apiResource('users', 'API\UserController');
    
    Route::post('registerFarmer', 'API\UserController@farmerRegister');
    
    Route::get('vegetable', 'API\VegetableController@getVegetable');
    Route::post('vegetableList', 'API\VegetableController@createVegeList');
    Route::apiResource('vegetables', 'API\VegetableController');

    Route::get('category/search', 'API\CategoryController@search');
    Route::apiResource('category', 'API\CategoryController');

    Route::get('roles/active', 'API\RoleController@activeRole');
    Route::apiResource('roles', 'API\RoleController');
});