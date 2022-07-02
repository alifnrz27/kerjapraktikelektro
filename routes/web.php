<?php

use App\Http\Controllers\CheckEmailController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\JobTrainingController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\SubmissionJobTrainingController;
use App\Http\Controllers\SubmissionLetterController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/kerja-praktik', [JobTrainingController::class, 'index']);

    Route::post('/upload-submission', [SubmissionJobTrainingController::class, 'uploadSubmission']);
    Route::post('/upload-member-submission', [SubmissionJobTrainingController::class, 'uploadMemberSubmission']);
    Route::post('/upload-letter', [SubmissionLetterController::class, 'upload']);

    Route::post('/input-logbook', [LogbookController::class, 'input']);

    Route::post('/accept-invitation', [InvitationController::class, 'acceptInvitation']);
    Route::post('/decline-invitation', [InvitationController::class, 'declineInvitation']);
    Route::post('/cancel-submission', [InvitationController::class, 'cancelSubmission']);
});
