<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\JobTrainingMentor;
use App\Models\Logbook;
use App\Models\MentoringJobTraining;
use App\Models\ReplyLetter;
use App\Models\SubmissionJobTraining;
use App\Models\SubmissionReport;
use App\Models\User;
use Illuminate\Http\Request;

class JobTrainingController extends Controller
{
    public function index(){
        $data =[
            'submissionStatus' => Null,
            'logbooks' => Null,
            'newSubmissions'=>Null,
            'newLetters' => Null,
            'chooseMentor' => Null,
            'academicYear' => Null,
            'mentors' => Null,
            'haveMentor'=>Null,
            'addMentoring' => Null,
            'mentoringQueue' => Null,
            'studentMentoringHistory' =>Null,
            'reportHistory' => Null,
            'reportQueue' => Null,
        ];

        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];

        // jika user adalah admin
        if(auth()->user()->role_id == 1){
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

            $chooseMentor = SubmissionJobTraining::where([
                'submission_status_id' => 13,
                'academic_year_id' => $academicYear->id,
            ])->get();
            if(count($chooseMentor) > 0){
                $data['chooseMentor'] = $chooseMentor;
            }

            $mentors = User::where([
                'role_id' => 2,
                'active_id' => 1,
            ])->get();
            if(count($mentors) > 0){
                $data['mentors'] = $mentors;
            }

            $haveMentor = JobTrainingMentor::where([
                'academic_year_id' => $academicYear->id,
            ])->get();
            if(count($haveMentor) > 0){
                $data['haveMentor'] = $haveMentor;
            }
        }


        // jika user adalah dosen 
        elseif(auth()->user()->role_id == 2){
            // apakah ada mahasiswa yang mengajukan bimbingan
            $addMentoring = MentoringJobTraining::where([
                'lecturer_id' => auth()->user()->id,
                'academic_year_id' =>$academicYear->id,
                'mentoring_status_id' => 1,
            ])->get();

            if(count($addMentoring) > 0){
                $data['addMentoring'] = $addMentoring;
            }

            // ambil data daftar antri bimbingan
            $mentoringQueue = MentoringJobTraining::where(['lecturer_id' => auth()->user()->id, 'academic_year_id' => $academicYear->id, 'mentoring_status_id'=>3])->get();
            if(count($mentoringQueue) > 0){
                $data['mentoringQueue'] = $mentoringQueue;
            }

            // ambil data daftar antri revisi
            $reportQueue = SubmissionReport::where(['lecturer_id' => auth()->user()->id, 'academic_year_id' => $academicYear->id, 'submission_report_status_id'=>1])->get();
            if(count($reportQueue) > 0){
                $data['reportQueue'] = $reportQueue;
            }
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

                // ambil data History bimbingan
                $studentMentoringHistory = MentoringJobTraining::where(['student_id' => auth()->user()->id, 'academic_year_id' => $academicYear->id])->get();
                if(count($studentMentoringHistory) > 0){
                    $data['studentMentoringHistory'] = $studentMentoringHistory;
                }

                $reportHistory = SubmissionReport::where([
                    'student_id' => auth()->user()->id,
                    'academic_year_id' => $academicYear->id,
                ])->get();

                if(count($reportHistory) > 0){
                    $data['reportHistory'] = $reportHistory;
                }
            }
        }

        $data['academicYear'] = $academicYear->id;
        return view('kerja-praktik.index', $data);
    }
}
