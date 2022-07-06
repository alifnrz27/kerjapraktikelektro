<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\JobTrainingMentor;
use App\Models\MentoringJobTraining;
use App\Models\SubmissionJobTraining;
use App\Models\SubmissionReport;
use App\Models\User;
use Illuminate\Http\Request;

class SubmissionReportController extends Controller
{
    public function add(Request $request){
        $academicYear = AcademicYear::get();
        $countSemester = count($academicYear);
        $academicYear = $academicYear[$countSemester-1];

        // cek apakah sebelumnya pernah mengajukan
        $check = SubmissionReport::where(['student_id' => auth()->user()->id, 'academic_year_id' => $academicYear->id, 'submission_report_status_id' => 1])->first();
        if($check) {
            return "menunggu di acc dosen";
        }
        $request->validate([
            'report' => 'required',
        ]);

        $mentorID = JobTrainingMentor::where([
            'student_id' => auth()->user()->id, 
            'academic_year_id' => $academicYear->id
        ])->first();

        if(!$mentorID){
            return "gaada";
        }

        SubmissionReport::create([
            'student_id' => auth()->user()->id,
            'lecturer_id' => $mentorID->lecturer_id,
            'report' => $request->report,
            'academic_year_id' => $academicYear->id,
            'submission_report_status_id' => 1,
            'description'=>'-',
        ]);


    }

    public function decline(Request $request, $id) {
        $request->validate([
            'description' => 'required',
        ]);
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = SubmissionReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'submission_report_status_id' => 1,
        ])->first();

        if(!$check){
            return "data gaada";
        }

        SubmissionReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'submission_report_status_id' => 1,
        ])->update([
            'submission_report_status_id' => 2,
            'description' =>$request->description,
        ]);
    }

    public function accept(Request $request, $id){
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = SubmissionReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'submission_report_status_id' => 1,
        ])->first();

        if(!$check){
            return "data gaada";
        }
        
        // cek apakah sudah 4 kali bimbingan
        $student = User::where(['id'=> $check->student_id])->first();
        $checkMentoring = MentoringJobTraining::where([
            'student_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'mentoring_status_id' => 4
        ])->get();

        // kalo udah 4 kali atau lebih
        if(count($checkMentoring) >= 4){
            SubmissionJobTraining::where([
                'user_id' => $check->student_id,
                'academic_year_id' =>$academicYear->id,
                'submission_status_id' => 15,
            ])->update([
                'submission_status_id' => 16,
            ]);

            SubmissionReport::where([
                'id' => $id,
                'lecturer_id' => auth()->user()->id,
                'academic_year_id' =>$academicYear->id,
                'submission_report_status_id' => 1,
            ])->update([
                'submission_report_status_id' => 3,
            ]);
        }

        else{
            return "mahasiswa belum bimbingan minimal 4 kali";
        }
    }
}
