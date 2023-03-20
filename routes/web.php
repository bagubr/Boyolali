<?php

use App\Http\Controllers\Agenda\HomeController as AgendaHomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DistrictController;
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
Route::prefix('agenda')->group(function () {
    Route::get('/', function () {
        return view('agenda/index');
    })->name('agenda');
    Route::post('login', [AgendaHomeController::class, 'login'])->name('agenda-login');
    Route::middleware(['auth-agenda'])->group(function () {
        Route::get('dashboard', [AgendaHomeController::class, 'home'])->name('dashboard-agenda');
        Route::get('berkas-proses', [AgendaHomeController::class, 'proses_berkas'])->name('agenda-berkas-proses');
        Route::get('revisi', [AgendaHomeController::class, 'revisi'])->name('agenda-revisi');
        Route::get('detail', [AgendaHomeController::class, 'detail'])->name('agenda-detail');
        Route::post('agenda-post/{id}', [AgendaHomeController::class, 'agenda_post'])->name('agenda-post');
        Route::post('logout', [AgendaHomeController::class, 'logout'])->name('agenda-logout');
        Route::post('reference', [AgendaHomeController::class, 'reference'])->name('agenda-reference');
        Route::post('delete-reference', [AgendaHomeController::class, 'delete_reference'])->name('agenda-delete-reference');
    });
});
Route::prefix('survei')->group(function () {
    Route::get('/', function () {
        return view('survei/index');
    })->name('survei');
    Route::post('login', [SurveiHomeController::class, 'login'])->name('survei-login');
    Route::middleware(['auth-survei'])->group(function () {
        Route::get('dashboard', [SurveiHomeController::class, 'home'])->name('dashboard-survei');
        Route::post('logout', [SurveiHomeController::class, 'logout'])->name('survei-logout');
        
        Route::get('berkas-proses', [SurveiHomeController::class, 'proses_berkas'])->name('survei-berkas-proses');
        Route::get('revisi', [SurveiHomeController::class, 'revisi'])->name('survei-revisi');
        Route::get('detail', [SurveiHomeController::class, 'detail'])->name('survei-detail');
        Route::post('survei-bap', [SurveiHomeController::class, 'survei_bap'])->name('survei-bap');
        Route::get('survei-interrogation-report', [SurveiHomeController::class, 'survei_interrogation_report'])->name('survei-interrogation-report');
        Route::get('survei-approve', [SurveiHomeController::class, 'approve'])->name('survei-approve');
        Route::get('delete-bap', [SurveiHomeController::class, 'delete_bap'])->name('delete-bap');
    });
});

Route::prefix('sketch')->group(function () {
    Route::get('/', function () {
        return view('sketch/index');
    })->name('sketch');
    Route::post('login', [SketchHomeController::class, 'login'])->name('sketch-login');
    Route::middleware(['auth-sketch'])->group(function () {
        Route::get('dashboard', [SketchHomeController::class, 'home'])->name('dashboard-sketch');
        Route::post('logout', [SketchHomeController::class, 'logout'])->name('sketch-logout');
    });
});


