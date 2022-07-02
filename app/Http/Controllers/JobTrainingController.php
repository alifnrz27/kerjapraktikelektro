<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Logbook;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class JobTrainingController extends Controller
{
    public function index(){
        // jika user adalah mahasiswa
        if(auth()->user()->role_id == 3){
            $currentSemester = AcademicYear::get();
            $countSemester = count($currentSemester);
            $currentSemester = $currentSemester[$countSemester-1];
            $lastSubmission = SubmissionJobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' => $currentSemester->id,
            ])->get();
            $data =[
                'submissionStatus' => Null,
                'logbooks' => Null,
            ];

            if (count($lastSubmission) > 0){
                $countSubmission = count($lastSubmission);
                $lastSubmission = $lastSubmission[$countSubmission-1];
                $data['submissionStatus'] = $lastSubmission->submission_status_id;

                
                // ambil data logbook
                $logbooks = Logbook::where(['user_id' => auth()->user()->id, 'submission_job_training_id' => $lastSubmission->id])->get();
                if(count($logbooks) > 0){
                    $data['logbooks'] = $logbooks;
                }
            }
        }

        return view('kerja-praktik.index', $data);
    }
}
