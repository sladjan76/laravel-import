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

### CMS API Routes ###
Route::post('users_ajax', 'App\\Http\\Controllers\\Admin\\UsersController@users');
Route::get('user_delete/{id}', 'App\\Http\\Controllers\\Admin\\UsersController@destroy');

Route::post('import_history_ajax', 'App\\Http\\Controllers\\Admin\\ImportHistoryController@imports');
Route::get('import_history_delete/{id}', 'App\\Http\\Controllers\\Admin\\ImportHistoryController@destroy');
