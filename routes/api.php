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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\Api\LoginController@authenticate');
Route::middleware('auth:sanctum')->get('/movies', 'App\Http\Controllers\Api\MovieController@movies');
Route::middleware('auth:sanctum')->get('/movie/{id}', 'App\Http\Controllers\Api\MovieController@movie');