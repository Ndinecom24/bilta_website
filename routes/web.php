<?php

use App\Http\Livewire\Admin\Company\ShowAboutUs;
use App\Http\Livewire\Admin\Company\ShowContactUsDetails;
use App\Http\Livewire\Admin\Company\ShowAdminHome;
use App\Http\Livewire\Admin\Company\ShowHomeIntro;
use App\Http\Livewire\Admin\Company\ShowLeadershipTeam;
use App\Http\Livewire\Admin\Company\ShowServices;
use App\Http\Livewire\Admin\Company\ShowValues;
use App\Http\Livewire\Admin\PrayerPointsPage\ShowPrayerPoints;
use App\Http\Livewire\Admin\TestimoniesPage\ShowTestimonialsPage;
use App\Http\Livewire\Admin\TestimoniesPage\ShowTestimonies;
use App\Http\Livewire\Site\ShowFAQs;
use App\Http\Livewire\Site\ShowHomePage;
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

Route::get('/', ShowHomePage::class)->name('site.home');
Route::get('/home', ShowHomePage::class)->name('site.home');
Route::prefix('bilta/site')->group(function () {
//    Route::get('home', \App\Http\Livewire\Site\ShowHomePage::class)->name('site.home');
});


///////////////////////////////////////////////////////////////////////////////////////////////////////
/// ADMIN
//////////////////////////////////////////////////////////////////////////////////////////////////////

Route::middleware(['auth'])->prefix('bilta/zadmin')->group(function () {
    Route::prefix('home')->group(function () {
        Route::get('/', ShowAdminHome::class)->name('admin.home');
        Route::get('/company/about-us', ShowAboutUs::class)->name('admin.company.about-us');
        Route::get('/company/services', ShowServices::class)->name('admin.company.services');
        Route::get('/company/values', ShowValues::class)->name('admin.company.values');
        Route::get('/company/contact-us', ShowContactUsDetails::class)->name('admin.company.contact-us');
        Route::get('/company/faqs', ShowFAQs::class)->name('admin.company.faqs');
        Route::get('/page/weekly-prayer-points', ShowPrayerPoints::class)->name('admin.page.weekly-prayer-points');
        Route::get('/page/our-team', ShowLeadershipTeam::class)->name('admin.page.our-team');
        Route::get('/page/testimonies', ShowTestimonies::class)->name('admin.page.testimonies');
        Route::get('/page/testimonial', ShowTestimonialsPage::class)->name('admin.page.testimonial');
        Route::get('/company/intro', ShowHomeIntro::class)->name('admin.page.intro');
    });
});
