<?php

use Illuminate\Support\Facades\Route;



// Super Admin / System Admin operational area
Route::prefix('system')->middleware(['auth'])->group(function () {
    // Master security: roles & permissions restricted to super-admin & admin
    Route::middleware('permission:manage-roles')->group(function () {
        Route::get('roles', \App\Http\Livewire\System\RolesIndex::class)->name('system.roles');
        Route::get('roles/{role}', \App\Http\Livewire\System\RolesShow::class)->name('system.roles.show');
    });

    Route::middleware('permission:manage-permissions')->group(function () {
        Route::get('permissions', \App\Http\Livewire\System\PermissionsIndex::class)->name('system.permissions');
    });

    // Status management: super-admin, admin, system-admin
    Route::middleware('permission:manage-statuses')->group(function () {
        Route::get('statuses', \App\Http\Livewire\System\StatusIndex::class)->name('system.statuses');
    });

    // User management & analytics
    Route::middleware('permission:manage-users')->group(function () {
        Route::get('users', \App\Http\Livewire\System\UsersIndex::class)->name('system.users');
        Route::get('user-analytics', \App\Http\Livewire\System\UserAnalytics::class)->name('system.user-analytics');
    });
});

// User profile — accessible to all authenticated users (self-access or admin)
Route::prefix('system')->middleware('auth')->group(function () {
    Route::post('users/{uuid}', \App\Http\Livewire\System\UsersShow::class)->name('system.users.show');
});
