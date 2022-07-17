<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\SubmissionAfterPresentation;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class SubmissionAfterPresentationController extends Controller
{
    public function add(Request $request){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        $request->validate([
            'evaluate_presentation'=> 'required',
            'evaluate_mentoring'=> 'required',
            'notes'=> 'required',
            'official_report'=> 'required',
            'report_rev'=> 'required',
            'submission_after_presentation_status_id'=> 'required',
        ]);
        
        // cek apakah sebelumnya masih mengajukan atau tidak, jika iya maka batalkan
        $check = SubmissionAfterPresentation::where([
            'academic_year_id' => $academicYear->id,
            'student_id' => auth()->user()->id,
            'submission_after_presentation_status_id' => 1,
        ])->first();

        if($check){
            return back()->with('status', 'Menunggu pengajuan sebelumnya');
        }


        SubmissionAfterPresentation::create([
            'student_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'evaluate_presentation' => $request->evaluate_presentation,
            'evaluate_mentoring' => $request->evaluate_mentoring,
            'notes' => $request->notes,
            'official_report' => $request->official_report,
            'report_rev' => $request->report_rev,
            'submission_after_presentation_status_id' => 1,
        ]);

        $lastSubmission = SubmissionJobTraining::where(['user_id' => auth()->user()->id, 'academic_year_id' => $academicYear->id])->latest()->first();

        if($lastSubmission->submission_status_id == 25){
            SubmissionJobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' => $academicYear->id,
                'submission_status_id' => 25,
            ])->update([
                'submission_status_id' => 26,
            ]);
        }elseif($lastSubmission->submission_status_id == 27){
            SubmissionJobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' => $academicYear->id,
                'submission_status_id' => 27,
            ])->update([
                'submission_status_id' => 26,
            ]);
        }
        return back()->with('status', 'Berhasil mengajukan berkas');
    }

    public function accept(Request $request, $studentID, $id){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = SubmissionAfterPresentation::where([
            'academic_year_id' => $academicYear->id,
            'student_id' => $studentID,
            'id' => $id,
            'submission_after_presentation_status_id' => 1,
        ])->first();
        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        SubmissionAfterPresentation::where([
            'student_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'submission_after_presentation_status_id' => 1,
        ])->update([
            'submission_after_presentation_status_id' => 3,
        ]);

        SubmissionJobTraining::where([
            'user_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 26,
        ])->update([
            'submission_status_id' => 28,
        ]);

        return back()->with('status', 'Berhasil menerima berkas');
    }

    public function decline(Request $request, $studentID, $id){
        $request->validate([
            'description' => 'required',
        ]);
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = beforePresentation::where([
            'academic_year_id' => $academicYear->id,
            'student_id' => $studentID,
            'id' => $id,
            'before_presentation_status_id' => 1,
        ])->first();
        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        beforePresentation::where([
            'student_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'before_presentation_status_id' => 1,
        ])->update([
            'before_presentation_status_id' => 2,
            'description' => $request->description,
        ]);

        SubmissionJobTraining::where([
            'user_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 19,
        ])->update([
            'submission_status_id' => 20,
        ]);

        return back()->with('status', 'Berhasil menolak berkas');
    }
}
