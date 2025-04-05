<?php

use Illuminate\Support\Facades\Route;
use ABMemon\SentinelRBAC\Http\Controllers\UserRoleController;
use ABMemon\SentinelRBAC\Http\Controllers\UserPermissionController;
use ABMemon\SentinelRBAC\Http\Controllers\GroupPermissionController;
use ABMemon\SentinelRBAC\Http\Controllers\GroupUserController;

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('rbac')->group(function () {
    Route::post('/users/{user}/roles/sync', [UserRoleController::class, 'sync']);
    Route::post('/users/{user}/permissions/sync', [UserPermissionController::class, 'sync']);
    Route::post('/groups/{group}/permissions/sync', [GroupPermissionController::class, 'sync']);
    Route::post('/groups/{group}/users/sync', [GroupUserController::class, 'sync']);
});
