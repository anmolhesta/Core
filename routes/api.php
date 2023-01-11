<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/student/register', [AuthController::class, 'StudentRegister']);
Route::post('/teacher/register', [AuthController::class, 'TeacherRegister']);
Route::post('/teacher/login', [AuthController::class, 'TeacherUserLogin']);
Route::post('/student/login', [AuthController::class, 'StudentUserLogin']);
Route::post('/admin/login', [AuthController::class, 'AdminUserLogin']);
Route::post('/teacher/assignment', [ServiceController::class, 'assignTeacher']);
Route::put('/user/profile/approval', [ServiceController::class, 'approveProfile']);

