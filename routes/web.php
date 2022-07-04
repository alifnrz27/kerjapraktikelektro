<?php

use App\Http\Controllers\CheckEmailController;
use App\Http\Controllers\ChooseMentorController;
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
    Route::post('/accept-submission/{user}/{submission}', [SubmissionJobTrainingController::class, 'acceptSubmission']);
    Route::post('/decline-submission/{user}/{submission}', [SubmissionJobTrainingController::class, 'declineSubmission']);
    Route::post('/accept-letter/{user}/{team}', [SubmissionLetterController::class, 'acceptLetter']);
    Route::post('/decline-letter/{user}/{team}', [SubmissionLetterController::class, 'declineLetter']);
    Route::post('/upload-letter', [SubmissionLetterController::class, 'upload']);

    Route::post('/input-logbook', [LogbookController::class, 'input']);

    Route::post('/accept-invitation', [InvitationController::class, 'acceptInvitation']);
    Route::post('/decline-invitation', [InvitationController::class, 'declineInvitation']);
    Route::post('/cancel-submission', [InvitationController::class, 'cancelSubmission']);

    Route::put('/choose-mentor/{user}/{id}', [ChooseMentorController::class, 'update']);
    Route::delete('/choose-mentor/{user}/{id}', [ChooseMentorController::class, 'destroy']);
    Route::resource('/choose-mentor/{user}', ChooseMentorController::class)->except(['update', 'destroy', 'index', 'create', 'show', 'edit']);
});
