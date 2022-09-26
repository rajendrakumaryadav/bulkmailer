<?php

    use App\Http\Controllers\DraftController;
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

    Route::post('/mailer-webhook', [JobScheduleController::class, 'addWebhook'])->name('mailer.webhook');

    Route::post('/create-job', [DraftController::class, 'index'])->name('draft.new');
    Route::post('/add_to_draft/{id}', [DraftController::class, 'modify'])->name('draft.modify');
    Route::get("/get-draft/{id}", [DraftController::class, 'edit'])->name('draft.edit');
    Route::put("/disable-schedule/{id}", [DraftController::class, 'disable_schedule'])->name('draft.disable_schedule');
    Route::get('/get-drafts', [DraftController::class, 'getDrafts'])->name('draft.get');
    Route::delete('/delete-task/{id}', [DraftController::class, 'destroy'])->name('draft.delete');
