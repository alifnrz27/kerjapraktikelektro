<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Evaluate;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class EvaluateController extends Controller
{
    public function add(Request $request, $studentID, $id){
        $request->validate([
            'understanding_score' => 'required',
            'analysis_score' => 'required',
            'report_score' => 'required',
            'description_mentoring' => 'required',
            'presentation_score' => 'required',
            'content_score' => 'required',
            'qna_score' => 'required',
            'description_presentation' => 'required',
        ]);
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = Evaluate::where([
            'academic_year_id' => $academicYear->id,
            'student_id' => $studentID,
            'id' => $id,
            'evaluate_status_id' => 1,
        ])->first();
        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        Evaluate::where([
            'id' => $id,
            'student_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'before_presentation_status_id' => 1,
        ])->update([
            'understanding_score' => $request->understanding_score,
            'analysis_score' => $request->analysis_score,
            'report_score' => $request->report_score,
            'description_mentoring' => $request->description_mentoring,
            'presentation_score' => $request->presentation_score,
            'content_score' => $request->content_score,
            'qna_score' => $request->qna_score,
            'description_presentation' => $request->description_presentation,
            'evaluate_status_id' => 2,
        ]);

        SubmissionJobTraining::where([
            'user_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 24,
        ])->update([
            'submission_status_id' => 25,
        ]);

        return back()->with('status', 'Berhasil memasukan nilai');
    }

    public function update(Request $request, $studentID, $id){
        $request->validate([
            'understanding_score' => 'required',
            'analysis_score' => 'required',
            'report_score' => 'required',
            'description_mentoring' => 'required',
            'presentation_score' => 'required',
            'content_score' => 'required',
            'qna_score' => 'required',
            'description_presentation' => 'required',
        ]);
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = Evaluate::where([
            'academic_year_id' => $academicYear->id,
            'student_id' => $studentID,
            'id' => $id,
            'evaluate_status_id' => 2,
        ])->first();
        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        Evaluate::where([
            'id' => $id,
            'student_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'before_presentation_status_id' => 2,
        ])->update([
            'understanding_score' => $request->understanding_score,
            'analysis_score' => $request->analysis_score,
            'report_score' => $request->report_score,
            'description_mentoring' => $request->description_mentoring,
            'presentation_score' => $request->presentation_score,
            'content_score' => $request->content_score,
            'qna_score' => $request->qna_score,
            'description_presentation' => $request->description_presentation,
        ]);

        return back()->with('status', 'Berhasil mengubah nilai');
    }
}
