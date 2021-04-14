<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
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
    Route::get('project/{project}/members', [ProjectController::class , 'members']);
    Route::get('project/{project}/members/{member}', [ProjectController::class , 'member']);
    Route::delete('project/{project}/members/{member}', [ProjectController::class , 'deleteMember']);

    Route::apiResource('group', GroupController::class)->only(['index', 'show']);
    Route::get('group/{group}/members', [GroupController::class , 'members']);
    Route::get('group/{group}/projects', [GroupController::class , 'projects']);
    Route::get('group/{group}/members/{member}', [GroupController::class , 'member']);
    Route::delete('group/{group}/members/{member}', [GroupController::class , 'deleteMember']);

    Route::apiResource('member', MemberController::class)->only(['index', 'show']);

    Route::apiResource('user', UserController::class);

});

Route::post('login', [AuthController::class , 'login']);
