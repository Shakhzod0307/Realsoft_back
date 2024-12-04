<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdvantageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login',[AuthController::class,'login'])->name('login');
Route::post('/admin/login',[AuthController::class,'loginCheck'])->name('admin-login');
Route::post('/admin/logout',[AuthController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Service
    Route::get('admin-services-dashboard', [AdminController::class, 'dashboard'])->name('admin-service-dashboard');
    Route::post('service',[ServicesController::class,'service'])->name('admin-service-store');
    Route::delete('service/{id}',[ServicesController::class,'serviceDelete'])->name('admin-service-delete');
    Route::put('service/{id}',[ServicesController::class,'serviceUpdate'])->name('admin-service-update');
    // Blogs
    Route::get('admin-blogs-dashboard', [BlogsController::class, 'dashboard'])->name('admin-blog-dashboard');
    Route::post('blog',[BlogsController::class,'blogCreate'])->name('admin-blog-store');
    Route::delete('blog/{id}',[BlogsController::class,'blogDelete'])->name('admin-blog-delete');
    Route::post('blog/{id}',[BlogsController::class,'blogUpdate'])->name('admin-blog-update');
    // Sectors
    Route::get('admin-sectors-dashboard', [SectorController::class, 'dashboard'])->name('admin-sector-dashboard');
    Route::post('sector',[SectorController::class,'sectorCreate'])->name('admin-sector-store');
    Route::delete('sector/{id}',[SectorController::class,'sectorDelete'])->name('admin-sector-delete');
    Route::post('sector/{id}',[SectorController::class,'sectorUpdate'])->name('admin-sector-update');
    Route::get('admin-forms-dashboard', [FormController::class, 'index'])->name('admin-form-dashboard');
    //Advantages
    Route::get('admin-advantages-dashboard', [AdvantageController::class, 'dashboard'])->name('admin-advantages-dashboard');
    Route::post('advantage',[AdvantageController::class,'advantageCreate'])->name('admin-advantage-store');
    Route::delete('advantage/{id}',[AdvantageController::class,'advantageDelete'])->name('admin-advantage-delete');
    Route::post('advantage/{id}',[AdvantageController::class,'advantageUpdate'])->name('admin-advantage-update');
    //Teams
    Route::get('admin-teams-dashboard', [TeamController::class, 'dashboard'])->name('admin-teams-dashboard');
    Route::post('team',[TeamController::class,'teamCreate'])->name('admin-team-store');
    Route::delete('team/{id}',[TeamController::class,'teamDelete'])->name('admin-team-delete');
    Route::post('team/{id}',[TeamController::class,'teamUpdate'])->name('admin-team-update');
    //Partners
    Route::get('admin-partners-dashboard', [PartnerController::class, 'dashboard'])->name('admin-partners-dashboard');
    Route::post('partner',[PartnerController::class,'partnerCreate'])->name('admin-partner-store');
    Route::delete('partner/{id}',[PartnerController::class,'partnerDelete'])->name('admin-partner-delete');
    Route::post('partner/{id}',[PartnerController::class,'partnerUpdate'])->name('admin-partner-update');
});


