<?php

use Illuminate\Support\Facades\Route;



Route::prefix('system')->middleware('role:admin')->group(function () {
    Route::get('statuses', \App\Http\Livewire\System\StatusIndex::class)->name('system.statuses');
    Route::get('permissions', \App\Http\Livewire\System\PermissionsIndex::class)->name('system.permissions');
    Route::get('roles', \App\Http\Livewire\System\RolesIndex::class)->name('system.roles');
    Route::get('roles/{role}', \App\Http\Livewire\System\RolesShow::class)->name('system.roles.show');
    Route::get('users', \App\Http\Livewire\System\UsersIndex::class)->name('system.users');
});

// User profile — accessible to all authenticated users (self-access or admin)
Route::prefix('system')->middleware('auth')->group(function () {
    Route::post('users/{uuid}', \App\Http\Livewire\System\UsersShow::class)->name('system.users.show');
});
