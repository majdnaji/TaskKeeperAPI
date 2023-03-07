<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\ProjectController;
use App\Http\Controllers\api\v1\TaskController;
use App\Http\Controllers\api\v1\UserController;

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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('user.login');
        Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:api'])->name('user.logout');


    });

    Route::middleware('auth:api')->group(function (){
        Route::middleware('role:admin')->group(function (){
            Route::apiResource('users',UserController::class);
        });
        Route::get("project/{id}/tasks",[TaskController::class,"tasksByProject"]);
        Route::apiResource('projects', ProjectController::class);
        Route::post("tasks/{id}/set-deadline",[TaskController::class,"setDeadline"]);
        Route::post("tasks/{id}/change-status",[TaskController::class,"changeStatus"]);
        Route::post("tasks/{id}/assign",[TaskController::class,"assignToDepartment"]);
        Route::post("tasks/{id}/revoke",[TaskController::class,"revokeFromDepartment"]);

        Route::apiResource("tasks",TaskController::class);

    });
});


