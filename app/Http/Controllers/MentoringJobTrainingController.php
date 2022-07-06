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
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];

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
            return 'belum boleh ajuin lagi, selesaiin dulu yg sebelumnya';
        }


        $mentor = JobTrainingMentor::where([
            'student_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id
        ])->first();
        MentoringJobTraining::create([
            'student_id'=>auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'mentoring_status_id' => 1,
            'lecturer_id' => $mentor->lecturer_id,
            'time' => '-',
            'description'=> '-',
        ]);
    }

    public function accept(Request $request, $studentID){
        $request->validate([
            'time' => 'required',
            'description' => 'required',
        ]);


        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 1,
        ])->first();

        if(!$check){
            return "data gaada";
        }

        MentoringJobTraining::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 1,
        ])->update([
            'mentoring_status_id' => 3,
            'time' => $request->time,
            'description' => $request->description,
        ]);
    }

    public function decline(Request $request, $studentID){
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 1,
        ])->first();

        if(!$check){
            return "data gaada";
        }

        MentoringJobTraining::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 1,
        ])->update([
            'mentoring_status_id' => 2,
        ]);
    }

    public function cancel(Request $request, $queueID){
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->first();

        if(!$check){
            return "data gaada";
        }

        MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->update([
            'mentoring_status_id' => 2,
        ]);
    }

    public function finished(Request $request, $queueID){
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->first();

        if(!$check){
            return "data gaada";
        }

        MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->update([
            'mentoring_status_id' => 4,
        ]);
    }

    public function update(Request $request, $queueID){
        $request->validate([
            'time' => 'required',
            'description' => 'required',
        ]);
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = MentoringJobTraining::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'mentoring_status_id' => 3,
        ])->first();

        if(!$check){
            return "data gaada";
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
    }
}
