<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Task\SubTaskController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\User\MeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES
Route::get('me', [MeController::class, 'getMe']);


// Route group for authenticated users only
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('account/delete', [LoginController::class, 'deleteAccount']);

    //Tasks
    Route::get('tasks', [TaskController::class, 'index']);
    Route::get('tasks/today', [TaskController::class, 'getTasksForToday']);
    Route::get('tasks/completed', [TaskController::class, 'getCompletedTasks']);
    Route::get('tasks/{task}', [TaskController::class, 'findById']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::post('tasks/{task}', [TaskController::class, 'update']);
    Route::post('tasks/{task}/mark', [TaskController::class, 'markTaskAsCompleted']);
    Route::delete('tasks/{task}', [TaskController::class, 'destroy']);

    //SubTasks
    Route::post('sub-tasks/{task}', [SubTaskController::class, 'store']);
    Route::get('sub-tasks/{subTask}', [SubTaskController::class, 'findById']);
    Route::post('sub-tasks/{subTask}/update', [SubTaskController::class, 'update']);
    Route::post('sub-tasks/{subTask}/mark', [SubTaskController::class, 'markSubTaskAsCompleted']);
    Route::delete('sub-tasks/{subTask}', [SubTaskController::class, 'destroy']);
});

// Route group for guest users only
Route::group(['middleware' => ['guest:api']], function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('verification/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('verification/resend', [VerificationController::class, 'resend']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);
});
