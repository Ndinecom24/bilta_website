<?php

use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\NewsletterController;
use App\Http\Controllers\Site\SponsorInquiryController;
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
use App\Http\Livewire\Admin\Other\ShowFrontRequests;
use App\Http\Livewire\Admin\Other\ShowItemCategory;
use App\Http\Livewire\Admin\PrayerPointsPage\ShowPrayerPoints;
use App\Http\Livewire\Admin\TestimoniesPage\ShowTestimonialsPage;
use App\Http\Livewire\Admin\TestimoniesPage\ShowTestimonies;
use App\Http\Livewire\Admin\TranslationProjectsPage\DetailTranslationProjects;
use App\Http\Livewire\Admin\TranslationProjectsPage\ShowTranslationProjects;
use App\Http\Livewire\Admin\VideosPage\ShowItemVidoes;
use App\Http\Livewire\Admin\Analytics\ClickAnalytics;
use App\Http\Livewire\Admin\LeavePage\ShowLeaveTypes;
use App\Http\Livewire\Admin\LeavePage\ShowLeaveApplications;
use App\Http\Livewire\Admin\LeavePage\MyLeaveApplications;
use App\Http\Livewire\Admin\LeavePage\ShowLeaveBalances;
use App\Http\Livewire\Admin\LeavePage\ShowApprovalWorkflows;
use App\Http\Livewire\Admin\ShowTrainingCenter;


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
use App\Http\Livewire\Site\ShowServices as SiteShowServices;
use App\Http\Livewire\Site\ShowTranslationProjectDetails;
use App\Http\Livewire\Site\ShowVideos;
use App\Http\Livewire\Site\MyFaqs;
use App\Http\Livewire\Site\MyTestimonials;
use App\Http\Livewire\Site\MyTestimonies;
use App\Http\Livewire\Site\MyNewsList;
use App\Http\Livewire\Site\ShowWeeklyPrayerPoints;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();


///////////////////////////////////////////////////////////////////////////////////////////////////////
/// SITE
//////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/', ShowHome::class)->name('site.home');
Route::get('/home', ShowHome::class)->name('site.home');
Route::prefix('bilta/site')->group(function () {
    Route::get('/about', ShowAbout::class)->name('about');
    Route::get('/services', SiteShowServices::class)->name('services');
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
Route::post('/contact', [ContactController::class,  'store'])->middleware('throttle:3,1')->name('contact.store');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->middleware('throttle:3,1')->name('newsletter.subscribe');
Route::post('/sponsor/inquiry', [SponsorInquiryController::class, 'store'])->middleware('throttle:3,1')->name('sponsor.inquiry.store');
Route::post('/clear-cache', [HomeController::class, 'clearCache'])->middleware('auth')->name('admin.cache.clear');
Route::post('/submit-testimonial', [ContactController::class, 'storeTestimonial'])->middleware('throttle:3,1');

///////////////////////////////////////////////////////////////////////////////////////////////////////
/// ADMIN
//////////////////////////////////////////////////////////////////////////////////////////////////////

Route::middleware(['auth'])->prefix('bilta/zadmin')->group(function () {
    Route::prefix('home')->group(function () {
        Route::get('/', ShowAdminHome::class)->name('admin.home');

        // Company Information — permission-protected
        Route::get('/company/about-us', ShowAboutUs::class)->middleware('permission:manage-about-us')->name('admin.company.about-us');
        Route::get('/company/services', ShowServices::class)->middleware('permission:manage-services')->name('admin.company.services');
        Route::get('/company/values', ShowValues::class)->middleware('permission:manage-values')->name('admin.company.values');
        Route::get('/company/contact-us', ShowContactUsDetails::class)->middleware('permission:manage-contact-us')->name('admin.company.contact-us');
        Route::get('/company/faqs', ShowFaqs::class)->middleware('permission:manage-faqs')->name('admin.company.faqs');
        Route::get('/page/weekly-prayer-points', ShowPrayerPoints::class)->middleware('permission:manage-prayer-points')->name('admin.page.weekly-prayer-points');
        Route::get('/page/our-team', ShowLeadershipTeam::class)->middleware('permission:manage-team')->name('admin.page.our-team');
        Route::get('/page/testimonies', ShowTestimonies::class)->middleware('permission:manage-testimonies')->name('admin.page.testimonies');
        Route::get('/page/testimonial', ShowTestimonialsPage::class)->middleware('permission:manage-testimonials')->name('admin.page.testimonial');
        Route::get('/company/intro', ShowHomeIntro::class)->middleware('permission:manage-home-intro')->name('admin.page.intro');
        Route::get('/chairmans/messages', ShowChairmansMessage::class)->middleware('permission:manage-chairman-message')->name('admin.page.chairmans.messages');
        Route::get('/our/sponsors', ShowOurSponsors::class)->middleware('permission:manage-sponsors')->name('admin.page.our.sponsors');
        Route::get('/contact/emails', ShowEmails::class)->middleware('permission:view-emails')->name('admin.page.contact.emails');
        Route::get('/front/requests', ShowFrontRequests::class)->middleware('permission:view-front-requests')->name('admin.page.front.requests');

        // Content Pages — permission-protected
        Route::get('/item/categories', ShowItemCategory::class)->middleware('permission:manage-categories')->name('admin.page.item.category');
        Route::get('/item/gallery', ShowItemGallery::class)->middleware('permission:manage-gallery')->name('admin.page.item.gallery');
        Route::get('/item/videos', ShowItemVidoes::class)->middleware('permission:manage-videos')->name('admin.page.item.videos');
        Route::get('/item/audio', ShowItemAudio::class)->middleware('permission:manage-audio')->name('admin.page.item.audio');
        Route::get('/item/news', ShowNewsItem::class)->middleware('permission:manage-news')->name('admin.page.item.news');
        Route::get('/item/news/{id}/details', ShowNewsItemDetails::class)->middleware('permission:manage-news')->name('admin.page.item.news.details');
        Route::get('/item/projects', ShowTranslationProjects::class)->middleware('permission:manage-projects')->name('admin.page.item.projects');
        Route::get('/item/projects/{item}/details', DetailTranslationProjects::class)->middleware('permission:manage-projects')->name('admin.page.item.projects.details');
        Route::get('/admin/live-analytics/clicks', ClickAnalytics::class)->middleware('permission:view-analytics')->name('admin.page.live.analytics.clicks');

        // Departments
        Route::get('/departments', \App\Http\Livewire\Admin\ShowDepartments::class)->middleware('permission:manage-departments')->name('admin.departments');

        // Leave Management — permission-protected
        Route::get('/leave/types', ShowLeaveTypes::class)->middleware('permission:manage-leave-types')->name('admin.leave.types');
        Route::get('/leave/applications', ShowLeaveApplications::class)->middleware('permission:manage-leave-applications')->name('admin.leave.applications');
        Route::get('/leave/my-applications', MyLeaveApplications::class)->middleware('permission:apply-leave')->name('admin.leave.my-applications');
        Route::get('/leave/balances', ShowLeaveBalances::class)->middleware('permission:manage-leave-balances')->name('admin.leave.balances');
        Route::get('/leave/workflows', ShowApprovalWorkflows::class)->middleware('permission:manage-approval-workflows')->name('admin.leave.workflows');

        // Training Center — accessible to all authenticated users
        Route::get('/training', ShowTrainingCenter::class)->name('admin.training');
    });
});