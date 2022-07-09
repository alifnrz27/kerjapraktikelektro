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
        $academicYear = AcademicYear::where(['is_active' => 1])->first();

        // cek apakah sebelumnya pernah mengajukan
        $check = SubmissionReport::where(['student_id' => auth()->user()->id, 'academic_year_id' => $academicYear->id, 'submission_report_status_id' => 1])->first();
        if($check) {
            return back()->with('status', 'silahkan menunggu pengajuan sebelumnya');
        }
        $request->validate([
            'report' => 'required',
        ]);

        $mentorID = JobTrainingMentor::where([
            'student_id' => auth()->user()->id, 
            'academic_year_id' => $academicYear->id
        ])->first();

        if(!$mentorID){
            return back()->with('status', 'Dosen pembimbing tidak ditemukan');
        }

        SubmissionReport::create([
            'student_id' => auth()->user()->id,
            'lecturer_id' => $mentorID->lecturer_id,
            'report' => $request->report,
            'academic_year_id' => $academicYear->id,
            'submission_report_status_id' => 1,
            'description'=>'-',
        ]);
        return back()->with('status', 'Berhasil mengajukan laporan');

    }

    public function decline(Request $request, $id) {
        $request->validate([
            'description' => 'required',
        ]);
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = SubmissionReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'submission_report_status_id' => 1,
        ])->first();

        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
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

        return back()->with('status', 'Laporan ditolak');
    }

    public function accept(Request $request, $id){
        $request->validate([
            'description' => 'required',
        ]);
        $academicYear = AcademicYear::where(['is_active'=>1])->first();
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = SubmissionReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'submission_report_status_id' => 1,
        ])->first();

        if(!$check){
            return back()->with('status', 'Data tidak');;
        }

        SubmissionReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' =>$academicYear->id,
            'submission_report_status_id' => 1,
        ])->update([
            'submission_report_status_id' => 3,
            'description' =>$request->description,
        ]);

        return back()->with('status', 'Berhasil menerima laporan');
    }
}
