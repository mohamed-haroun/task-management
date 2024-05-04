<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectAssignmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskLabelController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Authorization process using api
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Team management routes
    Route::apiResource('teams', TeamController::class);
    Route::post('/teams/{team}/members', [TeamController::class, 'addMember'])->name('teams.members.add');
    Route::delete('/teams/{team}/members/{member}', [TeamController::class, 'removeMember'])->name('teams.members.remove');

    // Projects management routes
    Route::apiResource('projects', ProjectController::class);
    Route::post('/projects/{project}/members', [ProjectAssignmentController::class, 'store'])->name('projects.members.store');
    Route::delete('/projects/{project}/members/{member}', [ProjectAssignmentController::class, 'destroy'])->name('projects.members.destroy');

    // Task lists management routes
    Route::apiResource('task_lists', TaskListController::class);

    // Task management routes
    Route::apiResource('tasks', TaskController::class);

    // Task labels management routes
    Route::post('tasks/{task}/labels', [TaskLabelController::class, 'store'])->name('tasks.labels.store');
    Route::patch('tasks/{task}/labels/{label}', [TaskLabelController::class, 'update'])->name('tasks.labels.update');
    Route::delete('tasks/{task}/labels/{label}', [TaskLabelController::class, 'destroy'])->name('tasks.labels.destroy');

    // Task attachments management routes
    Route::post('tasks/{task}/attachments', [AttachmentController::class, 'store'])->name('tasks.attachments.store');
    Route::patch('tasks/{task}/attachments/{attachment}', [AttachmentController::class, 'update'])->name('tasks.attachments.update');
    Route::delete('tasks/{task}/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('tasks.attachments.destroy');

    // Task Comments management routes
    Route::post('tasks/{task}/comments', [CommentController::class, 'store'])->name('tasks.comments.store');
    Route::patch('tasks/{task}/comments/{comment}', [CommentController::class, 'update'])->name('tasks.comments.update');
    Route::delete('tasks/{task}/comments/{comment}', [CommentController::class, 'destroy'])->name('tasks.comments.destroy');

    /**
     * Permissions and roles management routes
     *
     * (1): Permission management routes
     */
    Route::apiResource('permissions', PermissionController::class);


    // Roles management routes
    Route::apiResource('roles', RoleController::class);
});
