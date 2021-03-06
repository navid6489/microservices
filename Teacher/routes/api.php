<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\TeacherController;
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
 //   return $request->user();
//});
Route::post('/getData',[TeacherController::class,'getData']);
Route::post('/getTeacherById',[TeacherController::class,'getTeacherById']);
Route::post('/approveTeacher',[TeacherController::class,'approveTeacher']);