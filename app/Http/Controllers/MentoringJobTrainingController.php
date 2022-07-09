<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\JobTrainingMentor;
use App\Models\MentoringJobTraining;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class MentoringJobTrainingController extends Controller
{
    public function add(){
        $academicYear = AcademicYear::where(['is_active'=>1])->first();
        $lastSubmission = SubmissionJobTraining::where(['user_id'=>auth()->user()->id, 'academic_year_id' => $academicYear->id])->latest()->first();

        // cek apakah pengajuan sebelumnya belum selesai
        $addMentorings = MentoringJobTraining::where([
            'student_id'=>auth()->user()->id,
            'academic_year_id' => $academicYear->id,
        ])->get();

        $statusMentoring = true; // true berarti bisa mengajukan
        foreach($addMentorings as $mentoring){
            // kalo ada yg belum selesai, maka gaboleh ajuin
            if($mentoring->mentoring_status_id != 4 && $mentoring->mentoring_status_id != 2){ 
                $statusMentoring = false;
            }
        }

        if($statusMentoring == false){
            return back()->with('status', 'belum boleh ajuin lagi, selesaiin dulu yg sebelumnya');
        }


        $mentor = JobTrainingMentor::where([
            'student_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id
        ])->first();
        MentoringJobTraining::create([
            'student_id'=>auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'submission_job_training_id'=>$lastSubmission->id,
            'mentoring_status_id' => 1,
            'lecturer_id' => $mentor->lecturer_id,
            'time' => '-',
            'description'=> '-',
        ]);

        return back()->with('status', 'Berhasil mengajukan bimbingan');
    }

    public function accept(Request $request, $studentID){
        $academicYear = AcademicYear::where(['is_active'=>1])->first();
        $lastSubmission = SubmissionJobTraining::where(['user_id'=>$studentID, 'academic_year_id' => $academicYear->id])->latest()->first();

        $request->validate([
            'time' => 'required',
            'description' => 'required',
        ]);


        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'submission_job_training_id'=>$lastSubmission->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 1,
        ])->first();

        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        MentoringJobTraining::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'submission_job_training_id'=>$lastSubmission->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 1,
        ])->update([
            'mentoring_status_id' => 3,
            'time' => $request->time,
            'description' => $request->description,
        ]);

        return back()->with('status', 'Data berhasil ditambahkan');
    }

    public function decline(Request $request, $studentID){
        $academicYear = AcademicYear::where(['is_active'=>1])->first();
        $lastSubmission = SubmissionJobTraining::where(['user_id'=>$studentID, 'academic_year_id' => $academicYear->id])->latest()->first();

        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'submission_job_training_id'=>$lastSubmission->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 1,
        ])->first();

        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        MentoringJobTraining::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'submission_job_training_id'=>$lastSubmission->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 1,
        ])->update([
            'mentoring_status_id' => 2,
        ]);

        return back()->with('status', 'Berhasil menolak');
    }

    public function cancel(Request $request, $queueID){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->first();

        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->update([
            'mentoring_status_id' => 2,
        ]);

        return back()->with('status', 'Berhasil membatalkan');
    }

    public function finished(Request $request, $queueID){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->first();

        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->update([
            'mentoring_status_id' => 4,
        ]);

        return back()->with('status', 'Berhasil merubah data');
    }

    public function update(Request $request, $queueID){
        $request->validate([
            'time' => 'required',
            'description' => 'required',
        ]);
        $academicYear = AcademicYear::where(['is_active' =>1])->first();
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->first();

        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->update([
            'time' => $request->time,
            'description' => $request->description
        ]);

        return back()->with('status', 'Berhasil update data');
    }
}
