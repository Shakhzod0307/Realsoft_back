<?php

use App\Http\Controllers\Api\AdvantageController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\SectorController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SocialMediaController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TextController;
use Illuminate\Support\Facades\Route;

Route::get('/get-services',[ServiceController::class,'services']);
Route::get('/get-blogs',[BlogController::class,'blogs']);
Route::get('/{id}/blog',[BlogController::class,'showBlog']);
Route::get('/get-sectors',[SectorController::class,'sectors']);
Route::get('/get-advantages',[AdvantageController::class,'advantages']);
Route::get('/get-forms',[FormController::class,'forms']);
Route::get('/get-teams',[TeamController::class,'teams']);
Route::get('/get-partners',[PartnerController::class,'partner']);
Route::get('/get-projects',[ProjectController::class,'projects']);
Route::get('/get-images',[ImageController::class,'getImages']);
Route::get('/get-contact',[ContactController::class,'index']);
Route::get('/get-social-media',[SocialMediaController::class,'index']);
Route::get('/get-statistics',[StatisticController::class,'index']);
Route::get('/get-texts',[TextController::class,'index']);
Route::post('/post-form',[FormController::class,'postForm']);

