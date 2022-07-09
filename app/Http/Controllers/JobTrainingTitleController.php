<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\JobTrainingMentor;
use App\Models\JobTrainingTitle;
use App\Models\MentoringJobTraining;
use App\Models\SubmissionJobTraining;
use App\Models\User;
use Illuminate\Http\Request;

class JobTrainingTitleController extends Controller
{
    public function add(Request $request){
        $request->validate([
            'title' => 'required',
        ]);
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah pernah mengajukan judul namun belum di acc
        $check = JobTrainingTitle::where([
            'student_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'job_training_title_status_id' => 1,
        ])->first();

        if($check){
            return back()->with('status', 'Menunggu dosen');
        }

        // cek apakah judul sudah diterima
        $check = JobTrainingTitle::where([
            'student_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'job_training_title_status_id' => 3,
        ])->first();

        if($check){
            return back()->with('status', 'Judul sudah ada');
        }

        // ambil data dosen
        $mentor = JobTrainingMentor::where([
            'student_id'=>auth()->user()->id,
            'academic_year_id'=>$academicYear->id,
        ])->first();

        // ambil data KP
        $lastSubmission = SubmissionJobTraining::where([
            'user_id'=>auth()->user()->id,
            'academic_year_id'=>$academicYear->id,
        ])->latest()->first();

        // Masukkan judul baru
        JobTrainingTitle::create([
            'student_id' => auth()->user()->id,
            'lecturer_id' =>$mentor->lecturer_id,
            'submission_job_training_id' => $lastSubmission->id,
            'academic_year_id' => $academicYear->id,
            'job_training_title_status_id' => 3,
            'title' => $request->title,
            'job_training_title_status_id' => 1,
        ]);

        SubmissionJobTraining::where([
            'id' => $lastSubmission->id
        ])->update(['submission_status_id' => 16]);
        return back()->with('status', 'Berhasil mengajukan judul');
    }

    public function accept(Request $request, $studentID, $id){

        $academicYear = AcademicYear::where(['is_active' => 1])->first();

        // cek apakah ada datanya
        $check = JobTrainingTitle::where([
            'id' => $id,
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'job_training_title_status_id' => 1,
        ])->first();

        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        JobTrainingTitle::where([
            'id' => $id,
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
        ])->update([
            'job_training_title_status_id' => 3,
        ]);

        // Student last submission
        $lastSubmission = SubmissionJobTraining::where([
            'user_id' => $studentID,
            'academic_year_id' => $academicYear->id,
        ])->latest()->first();

        SubmissionJobTraining::where([
            'id' => $lastSubmission->id
        ])->update([
            'submission_status_id' => 18,
        ]);

        return back()->with('status', 'Berhasil menerima judul');
    }

    public function decline (Request $request, $studentID, $id){
        $request->validate([
            'description' => 'required',
        ]);
        $academicYear = AcademicYear::where(['is_active' => 1])->first();

        // cek apakah ada datanya
        $check = JobTrainingTitle::where([
            'id' => $id,
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'job_training_title_status_id' => 1,
        ])->first();

        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        JobTrainingTitle::where([
            'id' => $id,
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
        ])->update([
            'job_training_title_status_id' => 2,
            'description' => $request->description,
        ]);

        // Student last submission
        $lastSubmission = SubmissionJobTraining::where([
            'user_id' => $studentID,
            'academic_year_id' => $academicYear->id,
        ])->latest()->first();

        SubmissionJobTraining::where([
            'id' => $lastSubmission->id
        ])->update([
            'submission_status_id' => 17,
        ]);

        return back()->with('status', 'Judul telah ditolak');
    }
}
