<?php

use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Livewire\Admin\AudioPage\ShowItemAudio;
use App\Http\Livewire\Admin\Company\ShowAboutUs;
use App\Http\Livewire\Admin\Company\ShowAdminHome;
use App\Http\Livewire\Admin\Company\ShowContactUsDetails;
use App\Http\Livewire\Admin\Company\ShowHomeIntro;
use App\Http\Livewire\Admin\Company\ShowLeadershipTeam;
use App\Http\Livewire\Admin\Company\ShowServices;
use App\Http\Livewire\Admin\Company\ShowValues;
use App\Http\Livewire\Admin\FaqsPage\ShowFaqs;
use App\Http\Livewire\Admin\GalleryPage\ShowItemGallery;
use App\Http\Livewire\Admin\NewsPage\ShowNewsItem;
use App\Http\Livewire\Admin\NewsPage\ShowNewsItemDetails; 
use App\Http\Livewire\Admin\Other\ShowChairmansMessage;
use App\Http\Livewire\Admin\Other\ShowOurSponsors;
use App\Http\Livewire\Admin\Other\ShowEmails;
use App\Http\Livewire\Admin\Other\ShowItemCategory;
use App\Http\Livewire\Admin\PrayerPointsPage\ShowPrayerPoints;
use App\Http\Livewire\Admin\TestimoniesPage\ShowTestimonialsPage;
use App\Http\Livewire\Admin\TestimoniesPage\ShowTestimonies;
use App\Http\Livewire\Admin\TranslationProjectsPage\DetailTranslationProjects;
use App\Http\Livewire\Admin\TranslationProjectsPage\ShowTranslationProjects;
use App\Http\Livewire\Admin\VideosPage\ShowItemVidoes;
use App\Http\Livewire\Admin\Analytics\ClickAnalytics;


use App\Http\Livewire\Site\Company\ShowAbout;
use App\Http\Livewire\Site\MyAudioBibleDetails;
use App\Http\Livewire\Site\MyAudioBibleList;
use App\Http\Livewire\Site\MyNewsDetails;
use App\Http\Livewire\Site\MyNewsSearch;
use App\Http\Livewire\Site\MyTranslationProjectDetails;
use App\Http\Livewire\Site\MyTranslationProjectsIndex;
use App\Http\Livewire\Site\MyTranslationProjectsList;
use App\Http\Livewire\Site\ShowGallery;
use App\Http\Livewire\Site\ShowHome;
use App\Http\Livewire\Site\ShowTranslationProjectDetails;
use App\Http\Livewire\Site\ShowVideos;
use App\Http\Livewire\Site\MyFaqs;
use App\Http\Livewire\Site\MyTestimonials;
use App\Http\Livewire\Site\MyTestimonies;
use App\Http\Livewire\Site\MyNewsList;
use App\Http\Livewire\Site\ShowWeeklyPrayerPoints;
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

Route::get('/', ShowHome::class)->name('site.home');
Route::get('/home', ShowHome::class)->name('site.home');
Route::prefix('bilta/site')->group(function () {
    Route::get('/about', ShowAbout::class)->name('about');
    Route::get('/videos', ShowVideos::class)->name('videos');
    Route::get('/Gallery', ShowGallery::class)->name('gallery');
    Route::get('/Faqs', MyFaqs::class)->name('faqs');
    Route::get('/Testimonies', MyTestimonies::class)->name('testimonies');
    Route::get('/Testimonials', MyTestimonials::class)->name('testimonials');
    Route::get('/news/details/{news}/{name}', MyNewsDetails::class)->name('news.details');
    Route::get('/news/{category_id}', MyNewsList::class)->name('news');
    Route::get('/projects/details/{project}', MyTranslationProjectDetails::class)->name('projects.details');
    Route::get('/projects/{category_id}', MyTranslationProjectsList::class)->name('projects');
    Route::get('/WeeklyPrayerPoint', ShowWeeklyPrayerPoints::class)->name('weekly-prayer-points');
    Route::get('/audio/bible', MyAudioBibleList::class)->name('audio.bible');
    Route::get('/audio/bible/{item}/details', MyAudioBibleDetails::class)->name('audio.bible.details');

});
Route::post('/contact', [ContactController::class,  'store'])->name('contact.store');
Route::post('/clear-cache', [HomeController::class, 'clearCache']);
Route::post('/submit-testimonial', [ContactController::class, 'storeTestimonial']);

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
        Route::get('/company/faqs', ShowFaqs::class)->name('admin.company.faqs');
        Route::get('/page/weekly-prayer-points', ShowPrayerPoints::class)->name('admin.page.weekly-prayer-points');
        Route::get('/page/our-team', ShowLeadershipTeam::class)->name('admin.page.our-team');
        Route::get('/page/testimonies', ShowTestimonies::class)->name('admin.page.testimonies');
        Route::get('/page/testimonial', ShowTestimonialsPage::class)->name('admin.page.testimonial');
        Route::get('/company/intro', ShowHomeIntro::class)->name('admin.page.intro');
        Route::get('/item/categories', ShowItemCategory::class)->name('admin.page.item.category');
        Route::get('/item/gallery', ShowItemGallery::class)->name('admin.page.item.gallery');
        Route::get('/item/videos', ShowItemVidoes::class)->name('admin.page.item.videos');
        Route::get('/item/audio', ShowItemAudio::class)->name('admin.page.item.audio');
        Route::get('/item/news', ShowNewsItem::class)->name('admin.page.item.news'); 
        Route::get('/contact/emails', ShowEmails::class)->name('admin.page.contact.emails');
        Route::get('/chairmans/messages', ShowChairmansMessage::class)->name('admin.page.chairmans.messages');
        Route::get('/our/sponsors', ShowOurSponsors::class)->name('admin.page.our.sponsors');
        Route::get('/item/news/{id}/details', ShowNewsItemDetails::class)->name('admin.page.item.news.details');
        Route::get('/item/projects', ShowTranslationProjects::class)->name('admin.page.item.projects');
        Route::get('/item/projects/{item}/details', DetailTranslationProjects::class)->name('admin.page.item.projects.details');
        Route::get('/admin/live-analytics/clicks', ClickAnalytics::class)->name('admin.page.live.analytics.clicks');

 
    
    });
});
