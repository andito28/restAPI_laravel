<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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

Route::get('/student',[StudentController::class,'index']);
Route::post('/student',[StudentController::class,'store']);
Route::put('/student/{id}',[StudentController::class,'update']);
Route::get('/student/{id}',[StudentController::class,'show']);
Route::delete('/student/{id}',[StudentController::class,'destroy']);
Route::get('/studentSearch',[StudentController::class,'search']);
