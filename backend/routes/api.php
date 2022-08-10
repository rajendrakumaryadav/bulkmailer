<?php

    use App\Http\Controllers\JobScheduleController;
    use App\Http\Controllers\MyController;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */
    Route::post('/sendmail', [MyController::class, 'index'])->name('form.store');
    Route::post('/mailer-webhook',
        [JobScheduleController::class, 'addWebhook'])->name('mailer.webhook');
