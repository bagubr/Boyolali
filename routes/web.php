<?php

use App\Admin\Controllers\AdministratorController;
use App\Http\Controllers\Administrator\HomeController as AdministratorHomeController;
use App\Http\Controllers\Agenda\HomeController as AgendaHomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cetak\HomeController as CetakHomeController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\Kabid\HomeController as KabidHomeController;
use App\Http\Controllers\Kadis\HomeController as KadisHomeController;
use App\Http\Controllers\Users\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Sketch\HomeController as SketchHomeController;
use App\Http\Controllers\SubDistrictController;
use App\Http\Controllers\Subkor\HomeController as SubkorHomeController;
use App\Http\Controllers\Survei\HomeController as SurveiHomeController;
use App\Mail\TestEmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
    return view('welcome');
});
Route::get('login', function () {
    return view('users/index');
})->name('login');
Route::get('virtual-office', function () {
    return view('index');
});
Route::get('test-email', function () {
    try {
        Mail::to('bagubragowo3@gmail.com')->send(new TestEmail());
        return 'Test email sent.';
    } catch (\Throwable $th) {
        return $th;
    }
});
Route::prefix('users')->group(function () {
    Route::get('/', function () {return view('users/index');})->name('users');
    Route::get('login', function () {return view('users/login');})->name('user-login');
    Route::get('authorized/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google-auth-callback');
    Route::get('authorized/google', [AuthController::class, 'redirectToGoogle'])->name('google-auth');
    Route::get('registration', function () {return view('users/registration');})->name('registration');
    Route::get('district', [DistrictController::class, 'district'])->name('district');
    Route::get('sub-district', [SubDistrictController::class, 'sub_district'])->name('sub-district');
    Route::post('login', [AuthController::class, 'login'])->name('user-login-post');
    Route::post('registration', [AuthController::class, 'registration'])->name('registration-post');
    
    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::get('dashboard', [HomeController::class, 'index'])->name('home');
        Route::get('data', [DataController::class, 'data'])->name('data');
        Route::get('daftar', [HomeController::class, 'daftar'])->name('daftar');
        Route::get('proses', [HomeController::class, 'proses'])->name('proses');
        Route::get('detail', [HomeController::class, 'detail'])->name('detail');
        Route::get('detail-approval', [HomeController::class, 'detail_approval'])->name('detail-approval');
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

        Route::post('approve', [AdministratorHomeController::class, 'approve'])->name('approve');
        Route::get('agenda-berkas-proses', [AgendaHomeController::class, 'proses_berkas'])->name('agenda-berkas-proses');
        Route::get('berkas-selesai-agenda', [AgendaHomeController::class, 'berkas_selesai'])->name('agenda-berkas-selesai');
        Route::get('berkas-selesai-detail', [AgendaHomeController::class, 'detail'])->name('berkas-selesai-detail');
        Route::post('berkas-selesai', [AgendaHomeController::class, 'berkas_selesai_post'])->name('berkas-selesai');
        Route::get('detail-agenda', [AgendaHomeController::class, 'detail'])->name('agenda-detail');
        Route::post('agenda-post/{id}', [AgendaHomeController::class, 'agenda_post'])->name('agenda-post');
        Route::post('nomorsk-post/{id}', [AgendaHomeController::class, 'nomorsk_post'])->name('nomorsk-post');
        Route::post('agenda-approve', [AgendaHomeController::class, 'agenda_approve'])->name('agenda-approve');
        Route::post('selesai-approve', [AgendaHomeController::class, 'selesai_approve'])->name('selesai-approve');
        Route::get('agenda-selesai', [AgendaHomeController::class, 'selesai'])->name('agenda-selesai');
        Route::get('detail-selesai', [AgendaHomeController::class, 'detail'])->name('selesai-detail');
        Route::post('reference', [AgendaHomeController::class, 'reference'])->name('agenda-reference');
        Route::post('pemohon', [AgendaHomeController::class, 'pemohon'])->name('agenda-pemohon');
        Route::post('sketch-upload', [SketchHomeController::class, 'upload'])->name('upload-file-sketch');
        Route::post('sketch-post', [SketchHomeController::class, 'sketch_post'])->name('sketch-post');

        Route::get('berkas-proses-subkor', [SubkorHomeController::class, 'proses_berkas'])->name('subkor-berkas-proses');
        Route::get('subkor-detail', [SubkorHomeController::class, 'detail'])->name('subkor-detail');
        Route::post('subkor-approve', [SubkorHomeController::class, 'approve'])->name('subkor-approve');
        Route::get('subkor-cek', [SubkorHomeController::class, 'cek'])->name('subkor-cek');
        Route::get('subkor-cek-detail', [SubkorHomeController::class, 'detail'])->name('subkor-cek-detail');

        Route::get('berkas-proses-kabid', [KabidHomeController::class, 'proses_berkas'])->name('kabid-berkas-proses');
        Route::get('kabid-detail', [KabidHomeController::class, 'detail'])->name('kabid-detail');
        Route::post('kabid-approve', [KabidHomeController::class, 'approve'])->name('kabid-approve');
        Route::get('kabid-cek', [KabidHomeController::class, 'cek'])->name('kabid-cek');
        Route::get('kabid-cek-detail', [KabidHomeController::class, 'detail'])->name('kabid-cek-detail');

        Route::get('berkas-proses-kadis', [KadisHomeController::class, 'proses_berkas'])->name('kadis-berkas-proses');
        Route::get('kadis-detail', [KadisHomeController::class, 'detail'])->name('kadis-detail');
        Route::post('kadis-approve', [KadisHomeController::class, 'approve'])->name('kadis-approve');
        Route::get('kadis-cek', [KadisHomeController::class, 'cek'])->name('kadis-cek');
        Route::get('kadis-cek-detail', [KadisHomeController::class, 'detail'])->name('kadis-cek-detail');

        Route::post('generate-file', [CetakHomeController::class, 'generate'])->name('generate-file');
        Route::get('admin-profile', [AdministratorHomeController::class, 'admin_profile'])->name('admin-profile');
        Route::post('admin-profile', [AdministratorHomeController::class, 'admin_profile'])->name('admin-profile-post');
    });
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

