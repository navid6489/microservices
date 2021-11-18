<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\UserController;
use App\Providers\RouteServiceProvider;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  //  return $request->user();

Route::post('/generatetoken',[UserController::class,'generatetoken']);
Route::middleware('auth:api')->post('/getData', [UserController::class,'getData']) ;
Route::middleware('auth:api')->post('/getTeacherById', [UserController::class,'getTeacherById']) ;
Route::middleware('auth:api')->post('/approveStudent', [UserController::class,'approveStudent']) ;
Route::middleware('auth:api')->post('/approveTeacher', [UserController::class,'approveTeacher']) ;
   