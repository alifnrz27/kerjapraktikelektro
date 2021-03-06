<?php

use App\Http\Controllers\BeforePresentationController;
use App\Http\Controllers\CheckEmailController;
use App\Http\Controllers\ChooseMentorController;
use App\Http\Controllers\EvaluateController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\JobTrainingController;
use App\Http\Controllers\JobTrainingTitleController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\MentoringJobTrainingController;
use App\Http\Controllers\SubmissionAfterPresentationController;
use App\Http\Controllers\SubmissionJobTrainingController;
use App\Http\Controllers\SubmissionLetterController;
use App\Http\Controllers\SubmissionReportController;
use App\Models\JobTrainingTitle;
use App\Models\MentoringJobTraining;
use App\Models\SubmissionAfterPresentation;
use App\Models\SubmissionReport;
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

    Route::post('/add-mentoring-job-training', [MentoringJobTrainingController::class, 'add']);
    Route::post('/decline-mentoring/{student}', [MentoringJobTrainingController::class, 'decline']);
    Route::post('/accept-mentoring/{student}', [MentoringJobTrainingController::class, 'accept']);
    Route::post('/cancel-mentoring/{id}', [MentoringJobTrainingController::class, 'cancel']);
    Route::post('/finished-mentoring/{id}', [MentoringJobTrainingController::class, 'finished']);
    Route::post('/update-mentoring/{id}', [MentoringJobTrainingController::class, 'update']);

    Route::post('/add-job-training-title', [JobTrainingTitleController::class, 'add']);
    Route::post('/accept-job-training-title/{student}/{id}', [JobTrainingTitleController::class, 'accept']);
    Route::post('/decline-job-training-title/{student}/{id}', [JobTrainingTitleController::class, 'decline']);

    Route::post('/addReport', [SubmissionReportController::class, 'add']);
    Route::post('/decline-report/{id}', [SubmissionReportController::class, 'decline']);
    Route::post('/accept-report/{id}', [SubmissionReportController::class, 'accept']);

    Route::post('/add-before-presentation', [BeforePresentationController::class, 'add']);
    Route::post('/decline-before-presentation/{student}/{id}', [BeforePresentationController::class, 'decline']);
    Route::post('/accept-before-presentation/{student}/{id}', [BeforePresentationController::class, 'accept']);

    Route::post('/accept-presentation/{student}/{id}', [PresentationController::class, 'accept']);

    Route::post('/eval-presentation/{student}/{id}', [EvaluateController::class, 'add']);
    Route::post('/update-eval-presentation/{student}/{id}', [EvaluateController::class, 'update']);

    Route::post('/add-form-after-presentation', [SubmissionAfterPresentationController::class, 'add']);
    Route::post('/decline-after-presentation/{student}/{id}', [SubmissionAfterPresentationController::class, 'decline']);
    Route::post('/accept-after-presentation/{student}/{id}', [SubmissionAfterPresentationController::class, 'accept']);
});
