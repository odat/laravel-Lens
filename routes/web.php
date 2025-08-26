<?php

use Odat\LaravelLens\Http\Controllers\LaravelLensAuthController;
use Odat\LaravelLens\Http\Controllers\LaravelLensController;
use Odat\LaravelLens\Http\Controllers\LaravelLensJobsController;
use Odat\LaravelLens\Http\Middleware\LaravelLensAuthMiddleware;

Route::controller(LaravelLensController::class)->middleware(['web', LaravelLensAuthMiddleware::class])
    ->prefix(config('laravel-lens.route-prefix'))->as('laravel-lens.')->group(function() {
   Route::get('', 'index')->name('index');
   Route::get('broken-access-control', 'brokenAccessControl')->name('broken-access-control');
    Route::get('cryptographic-failures', 'cryptographicFailures')->name('cryptographic-failures');
    Route::get('injection', 'injection')->name('injection');
    Route::get('insecure-design', 'insecureDesign')->name('insecure-design');
    Route::get('security-misconfiguration', 'securityMisconfiguration')->name('security-misconfiguration');
    Route::get('vulnerable-and-outdated-components', 'vulnerableAndOutdatedComponents')->name('vulnerable-and-outdated-components');
    Route::get('identification-and-authentication-failures', 'identificationAndAuthenticationFailures')->name('identification-and-authentication-failures');
    Route::get('software-and-data-integrity-failures', 'softwareAndDataIntegrityFailures')->name('software-and-data-integrity-failures');
    Route::get('security-logging-and-monitoring-failures', 'securityLoggingAndMonitoringFailures')->name('security-logging-and-monitoring-failures');
    Route::get('server-side-request-forgery', 'serverSideRequestForgery')->name('server-side-request-forgery');
    Route::get('commands-list', 'commandsList')->name('commands-list');
    Route::post('run-command', 'runCommand')->name('run-command');
    Route::post('check-command', 'checkCommand')->name('check-command');


    Route::controller(LaravelLensJobsController::class)->group(function() {
        Route::get('/lens/failed-jobs', 'failedJobList')->name('failed-jobs');
        Route::get('/lens/jobs',        'jobsList')->name('jobs');
    });
});

Route::controller(LaravelLensAuthController::class)->middleware(['web'])
    ->prefix(config('laravel-lens.route-prefix'))->as('laravel-lens-auth.')->group(function() {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'auth')->name('auth');
        Route::get('logout', 'logout')->name('logout');
});
