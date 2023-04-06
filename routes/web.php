<?php

use App\Http\Controllers\Administrator\HomeController as AdministratorHomeController;
use App\Http\Controllers\Agenda\HomeController as AgendaHomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\Kabid\HomeController as KabidHomeController;
use App\Http\Controllers\Users\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Sketch\HomeController as SketchHomeController;
use App\Http\Controllers\SubDistrictController;
use App\Http\Controllers\Survei\HomeController as SurveiHomeController;
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
Auth::routes(['verify' => true]);
Route::get('/', function () {
    return view('index');
});
Route::get('virtual-office', function () {
    return view('welcome');
});
Route::prefix('users')->group(function () {
    Route::get('/', function () {
        return view('users/index');
    });
    Route::get('login', function () {
        return view('users/login');
    })->name('user-login');
    Route::get('authorized/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google-auth-callback');
    Route::get('authorized/google', [AuthController::class, 'redirectToGoogle'])->name('google-auth');
    Route::get('registration', function ()
    {
        return view('users/registration');
    })->name('registration');
    Route::get('district', [DistrictController::class, 'district'])->name('district');
    Route::get('sub-district', [SubDistrictController::class, 'sub_district'])->name('sub-district');
    Route::post('login', [AuthController::class, 'login'])->name('user-login-post');
    Route::post('registration', [AuthController::class, 'registration'])->name('registration-post');
    Route::middleware(['auth-users'])->group(function () {
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::get('data', [DataController::class, 'data'])->name('data');
        Route::get('daftar', [HomeController::class, 'daftar'])->name('daftar');
        Route::get('proses', [HomeController::class, 'proses'])->name('proses');
        Route::get('detail', [HomeController::class, 'detail'])->name('detail');
        Route::post('upload', [HomeController::class, 'upload'])->name('upload');
        Route::post('user_information', [HomeController::class, 'user_information'])->name('user_information');
        Route::post('logout', [AuthController::class, 'logout'])->name('user-logout');
    });
});

Route::prefix('administrator')->group(function () {
    Route::get('/', function () {
        return view('administrator/index');
    })->name('administrator');
    Route::post('login', [AdministratorHomeController::class, 'login'])->name('administrator-login');
    Route::middleware(['auth-administrator'])->group(function () {
        Route::get('dashboard', [AdministratorHomeController::class, 'home'])->name('administrator-dashboard');
        Route::post('logout', [AdministratorHomeController::class, 'logout'])->name('administrator-logout');
        Route::get('approve', [AdministratorHomeController::class, 'approve'])->name('approve');
        Route::get('save', [AdministratorHomeController::class, 'save'])->name('save');
        Route::get('revision', [AdministratorHomeController::class, 'revision'])->name('revision');
        
        Route::get('berkas-proses-agenda', [AgendaHomeController::class, 'proses_berkas'])->name('agenda-berkas-proses');
        Route::get('berkas-selesai-agenda', [AgendaHomeController::class, 'berkas_selesai'])->name('agenda-berkas-selesai');
        Route::get('detail-agenda', [AgendaHomeController::class, 'detail'])->name('agenda-detail');
        Route::post('agenda-post/{id}', [AgendaHomeController::class, 'agenda_post'])->name('agenda-post');
        Route::get('agenda-revisi', [AgendaHomeController::class, 'revisi'])->name('agenda-revisi');
        Route::post('reference', [AgendaHomeController::class, 'reference'])->name('agenda-reference');
        
        // Route::get('berkas-proses-sketch', [SketchHomeController::class, 'proses_berkas'])->name('sketch-berkas-proses');
        // Route::get('sketch-detail', [SketchHomeController::class, 'detail'])->name('sketch-detail');
        Route::post('sketch-upload', [SketchHomeController::class, 'upload'])->name('upload-file-sketch');
        Route::post('sketch-post', [SketchHomeController::class, 'sketch_post'])->name('sketch-post');
        // Route::get('sketch-revisi', [SketchHomeController::class, 'revisi'])->name('sketch-revisi');
        
        Route::get('berkas-proses-kabid', [KabidHomeController::class, 'proses_berkas'])->name('kabid-berkas-proses');
        Route::get('kabid-detail', [KabidHomeController::class, 'detail'])->name('kabid-detail');
        Route::get('kabid-revisi', [KabidHomeController::class, 'revisi'])->name('kabid-revisi');
        
        Route::get('berkas-proses-kadis', [SketchHomeController::class, 'proses_berkas'])->name('kadis-berkas-proses');
        Route::get('kadis-revisi', [SketchHomeController::class, 'revisi'])->name('kadis-revisi');
    });
});


