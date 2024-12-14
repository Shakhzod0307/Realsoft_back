<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdvantageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TextController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/admin/login',[AuthController::class,'login'])->name('login');
Route::post('/admin/login',[AuthController::class,'loginCheck'])->name('admin-login');
Route::post('/admin/logout',[AuthController::class,'logout'])->name('logout');


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::middleware('auth')->group(function () {
        // Service
        Route::get('admin-services-dashboard', [AdminController::class, 'dashboard'])->name('admin-service-dashboard');
        Route::post('service', [ServicesController::class, 'service'])->name('admin-service-store');
        Route::delete('service/{id}', [ServicesController::class, 'serviceDelete'])->name('admin-service-delete');
        Route::put('service/{id}', [ServicesController::class, 'serviceUpdate'])->name('admin-service-update');
        // Blogs
        Route::get('admin-blogs-dashboard', [BlogsController::class, 'dashboard'])->name('admin-blog-dashboard');
        Route::post('blog', [BlogsController::class, 'blogCreate'])->name('admin-blog-store');
        Route::delete('blog/{id}', [BlogsController::class, 'blogDelete'])->name('admin-blog-delete');
        Route::post('blog/{id}', [BlogsController::class, 'blogUpdate'])->name('admin-blog-update');
        // Sectors
        Route::get('admin-sectors-dashboard', [SectorController::class, 'dashboard'])->name('admin-sector-dashboard');
        Route::post('sector', [SectorController::class, 'sectorCreate'])->name('admin-sector-store');
        Route::delete('sector/{id}', [SectorController::class, 'sectorDelete'])->name('admin-sector-delete');
        Route::post('sector/{id}', [SectorController::class, 'sectorUpdate'])->name('admin-sector-update');
        Route::get('admin-forms-dashboard', [FormController::class, 'index'])->name('admin-form-dashboard');
        //Advantages
        Route::get('admin-advantages-dashboard', [AdvantageController::class, 'dashboard'])->name('admin-advantages-dashboard');
        Route::post('advantage', [AdvantageController::class, 'advantageCreate'])->name('admin-advantage-store');
        Route::delete('advantage/{id}', [AdvantageController::class, 'advantageDelete'])->name('admin-advantage-delete');
        Route::post('advantage/{id}', [AdvantageController::class, 'advantageUpdate'])->name('admin-advantage-update');
        //Teams
        Route::get('admin-teams-dashboard', [TeamController::class, 'dashboard'])->name('admin-teams-dashboard');
        Route::post('team', [TeamController::class, 'teamCreate'])->name('admin-team-store');
        Route::delete('team/{id}', [TeamController::class, 'teamDelete'])->name('admin-team-delete');
        Route::post('team/{id}', [TeamController::class, 'teamUpdate'])->name('admin-team-update');
        //Partners
        Route::get('admin-partners-dashboard', [PartnerController::class, 'dashboard'])->name('admin-partners-dashboard');
        Route::post('partner', [PartnerController::class, 'partnerCreate'])->name('admin-partner-store');
        Route::delete('partner/{id}', [PartnerController::class, 'partnerDelete'])->name('admin-partner-delete');
        Route::post('partner/{id}', [PartnerController::class, 'partnerUpdate'])->name('admin-partner-update');
        //statistics
        Route::get('admin-statistics-dashboard', [StatisticController::class, 'dashboard'])->name('admin-statistics-dashboard');
        Route::post('statistic', [StatisticController::class, 'statisticCreate'])->name('admin-statistic-store');
        Route::delete('statistic/{id}', [StatisticController::class, 'statisticDelete'])->name('admin-statistic-delete');
        Route::post('statistic/{id}', [StatisticController::class, 'statisticUpdate'])->name('admin-statistic-update');
        //about
        Route::get('admin-about-dashboard', [AboutController::class, 'dashboard'])->name('admin-about-dashboard');
        Route::post('about', [AboutController::class, 'aboutCreate'])->name('admin-about-store');
        Route::delete('about/{id}', [AboutController::class, 'aboutDelete'])->name('admin-about-delete');
        Route::post('about/{id}', [AboutController::class, 'aboutUpdate'])->name('admin-about-update');
        //social-media
        Route::post('social-media', [SocialMediaController::class, 'socialMediaCreate'])->name('admin-social-media-store');
        Route::delete('social-media/{id}', [SocialMediaController::class, 'socialMediaDelete'])->name('admin-social-media-delete');
        Route::post('social-media/{id}', [SocialMediaController::class, 'socialMediaUpdate'])->name('admin-social-media-update');
        //images
        Route::get('admin-images-dashboard', [ImageController::class, 'dashboard'])->name('admin-images-dashboard');
        Route::post('image', [ImageController::class, 'imageCreate'])->name('admin-image-store');
        Route::delete('image/{id}', [ImageController::class, 'imageDelete'])->name('admin-image-delete');
        Route::post('image/{id}', [ImageController::class, 'imageUpdate'])->name('admin-image-update');
        //texts
        Route::get('admin-texts-dashboard', [TextController::class, 'dashboard'])->name('admin-texts-dashboard');
        Route::post('text', [TextController::class, 'textCreate'])->name('admin-text-store');
        Route::delete('text/{id}', [TextController::class, 'textDelete'])->name('admin-text-delete');
        Route::post('text/{id}', [TextController::class, 'textUpdate'])->name('admin-text-update');
    });
});

