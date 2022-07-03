<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Logbook;
use App\Models\ReplyLetter;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class JobTrainingController extends Controller
{
    public function index(){
        $data =[
            'submissionStatus' => Null,
            'logbooks' => Null,
            'newSubmissions'=>Null,
            'newLetters' => Null,
        ];
        // jika user adalah admin
        if(auth()->user()->role_id == 1){
            $academicYear = AcademicYear::get();
            $countAcademicYear = count($academicYear);
            $academicYear = $academicYear[$countAcademicYear-1];
            $newSubmissions = SubmissionJobTraining::where([
                'submission_status_id' => 1,
                'academic_year_id' => $academicYear->id,
            ])->get();

            if(count($newSubmissions) > 0){
                $data['newSubmissions'] = $newSubmissions;
            }

            $newLetters = ReplyLetter::where([
                'academic_year_id' => $academicYear->id,
                'reply_letter_status_id' => 1,
            ])->get();

            if(count($newLetters) > 0){
                $data['newLetters'] = $newLetters;
            }
        }


        // jika user adalah dosen 
        elseif(auth()->user()->role_id == 2){

        }


        // jika user adalah mahasiswa
        elseif(auth()->user()->role_id == 3){
            $currentSemester = AcademicYear::get();
            $countSemester = count($currentSemester);
            $currentSemester = $currentSemester[$countSemester-1];
            $lastSubmission = SubmissionJobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' => $currentSemester->id,
            ])->get();

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
