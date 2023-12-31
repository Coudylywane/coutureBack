<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;

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

Route::apiResource('categories',CategorieController::class);

Route::get('categories/{categorieId}/unites', 'App\Http\Controllers\CategorieController@getUnitesForCategorie');
Route::delete('/categories/{id}', 'App\Http\Controllers\CategorieController@destroy');
//Route::get('/all', 'App\Http\Controllers\CategorieController@findAll');