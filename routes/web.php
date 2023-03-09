<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();


///////////////////////////////////////////////////////////////////////////////////////////////////////
/// SITE
//////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/home', \App\Http\Livewire\Site\ShowHomePage::class)->name('site.home');
Route::prefix('bilta/site')->group(function () {
//    Route::get('home', \App\Http\Livewire\Site\ShowHomePage::class)->name('site.home');
});


///////////////////////////////////////////////////////////////////////////////////////////////////////
/// ADMIN
//////////////////////////////////////////////////////////////////////////////////////////////////////

Route::middleware(['auth'])->prefix('bilta/zadmin')->group(function () {
    Route::prefix('home')->group(function () {
        Route::get('/', \App\Http\Livewire\Admin\HomePage\ShowHome::class)->name('admin.home');
    });
});
