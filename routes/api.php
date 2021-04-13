<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('logout', [AuthController::class , 'logout']);
    Route::apiResource('project', ProjectController::class)->only(['index', 'show']);
    Route::apiResource('member', MemberController::class)->only(['index', 'show']);
    Route::apiResource('user', UserController::class);
    Route::get('project/{project}/members', [ProjectController::class , 'members']);
    Route::delete('project/{project}/members/{member}', [ProjectController::class , 'deleteMember']);

});

Route::post('login', [AuthController::class , 'login']);
