<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Project\InvitationController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Task\SubTaskController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\User\MeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Version 1
Route::group(['prefix' => 'v1'], function () {
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
        Route::put('tasks/{task}', [TaskController::class, 'update']);
        Route::post('tasks/{task}/mark', [TaskController::class, 'markTaskAsCompleted']);
        Route::delete('tasks/{task}', [TaskController::class, 'destroy']);

        //SubTasks
        Route::post('sub-tasks/{task}', [SubTaskController::class, 'store']);
        Route::get('sub-tasks/{subTask}', [SubTaskController::class, 'findById']);
        Route::put('sub-tasks/{subTask}/update', [SubTaskController::class, 'update']);
        Route::post('sub-tasks/{subTask}/mark', [SubTaskController::class, 'markSubTaskAsCompleted']);
        Route::delete('sub-tasks/{subTask}', [SubTaskController::class, 'destroy']);

        //Project
        Route::post('projects', [ProjectController::class, 'store']);
        // Route::get('projects', [ProjectController::class, 'index']);
        Route::get('projects/user', [ProjectController::class, 'fetchUserProjects']);
        Route::get('projects/{project}', [ProjectController::class, 'findById']);
        Route::put('projects/{project}', [ProjectController::class, 'update']);
        Route::delete('projects/{project}', [ProjectController::class, 'destroy']);
        Route::put('projects/{project}/tasks/{task}', [ProjectController::class, 'moveTaskToProject']);
        Route::post('projects/{project}/users/{user}', [ProjectController::class, 'removeUserFromProject']);

        //Invitation
        Route::post('invitations/projects/{project}', [InvitationController::class, 'invite']);
        Route::post('invitations/{invitation}/resend', [InvitationController::class, 'resend']);
        Route::post('invitations/{invitation}/respond', [InvitationController::class, 'respond']);
        Route::delete('invitation/{invitation}', [InvitationController::class, 'destroy']);
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
});
