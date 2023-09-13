<?php

use App\Admin\Controllers\AdminSketchController;
use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('user-informations', UserInformationController::class);
    $router->resource('activities', ActivityController::class);
    $router->resource('kbli-activities', KbliActivityController::class);
    $router->resource('districts', DistrictController::class);
    $router->resource('sub-districts', SubDistrictController::class);
    $router->resource('land-statuses', LandStatusController::class);
    $router->resource('additional-informations', AdditionalInformationController::class);
    $router->resource('building-functions', BuildingFunctionController::class);
    $router->resource('gsbs', GsbController::class);
    $router->resource('krks', KrkController::class);
    $router->resource('other-technical-informations', OtherTechnicalInformationController::class);
    $router->resource('term-and-conditions', TermAndConditionController::class);
    $router->resource('menu-applications', MenuApplicationController::class);
    $router->resource('informations', InformationController::class);
    $router->resource('social-medias', SocialMediaController::class);
    $router->resource('reference-types', ReferenceTypeController::class);
    $router->resource('settings', SettingController::class);
    $router->resource('admin-agendas', AdminAgendaController::class);
    $router->resource('revisions', RevisionController::class);
    $router->resource('admin-surveis', AdminSurveiController::class);
    $router->resource('interrogation-reports', InterrogationReportController::class);
    $router->resource('admin-sketches', AdminSketchController::class);
    $router->resource('administrators', AdministratorController::class);
});
