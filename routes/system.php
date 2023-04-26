<?php

use Illuminate\Support\Facades\Route;



Route::prefix('system')->group(function () {
    Route::get('statuses', \App\Http\Livewire\System\StatusIndex::class)->name('system.statuses');
    Route::get('permissions', \App\Http\Livewire\System\PermissionsIndex::class)->name('system.permissions');
    Route::get('roles', \App\Http\Livewire\System\RolesIndex::class)->name('system.roles');
    Route::get('roles/{role}', \App\Http\Livewire\System\RolesShow::class)->name('system.roles.show');
    Route::get('users', \App\Http\Livewire\System\UsersIndex::class)->name('system.users');
    Route::post('users/{user}', \App\Http\Livewire\System\UsersShow::class)->name('system.users.show');
});
