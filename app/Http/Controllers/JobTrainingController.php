<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class JobTrainingController extends Controller
{
    public function index(){
        $currentSemester = AcademicYear::get();
        $countSemester = count($currentSemester);
        $currentSemester = $currentSemester[$countSemester-1];
        $lastSubmission = SubmissionJobTraining::where([
            'user_id' => auth()->user()->id,
            'academic_year_id' => $currentSemester->id,
        ])->get();
        $data =[
            'submissionStatus' => Null,
        ];
        if (count($lastSubmission) > 0){
            $countSubmission = count($lastSubmission);
            $lastSubmission = $lastSubmission[$countSubmission-1];
            $data['submissionStatus'] = $lastSubmission->submission_status_id;
        }

        return view('kerja-praktik.index', $data);
    }
}
