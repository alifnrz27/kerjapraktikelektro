<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Evaluate;
use App\Models\JobTrainingMentor;
use App\Models\Presentation;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class PresentationController extends Controller
{
    public function accept(Request $request, $studentID, $id){
        $request->validate([
            'description'=>'required',
        ]);
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = Presentation::where([
            'academic_year_id' => $academicYear->id,
            'student_id' => $studentID,
            'id' => $id,
            'presentation_status_id' => 1,
        ])->first();
        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        Presentation::where([
            'student_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'presentation_status_id' => 1,
        ])->update([
            'presentation_status_id' => 2,
            'description'=> $request->description,
        ]);

        SubmissionJobTraining::where([
            'user_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 21,
        ])->update([
            'submission_status_id' => 24,
        ]);

        $lecturer = JobTrainingMentor::where(['student_id'=>$studentID, 'academic_year_id' => $academicYear->id])->first();

        Evaluate::create([
            'academic_year_id' => $academicYear->id,
            'student_id' => $studentID,
            'lecturer_id' => $lecturer->lecturer_id,
            'evaluate_status_id'=>1,
        ]);

        return back()->with('status', 'Berhasil menyelesaikank presentasi');
    }
}
