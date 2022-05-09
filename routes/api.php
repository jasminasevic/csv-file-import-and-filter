<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/book/{id}', 'App\Http\Controllers\Book\BookController@show');
Route::get('/book/{keyword?}', 'App\Http\Controllers\Book\BookController@index');

Route::post('/book/import-file', 'App\Http\Controllers\Book\BookController@importFile');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});



