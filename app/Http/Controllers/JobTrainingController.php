<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\JobTrainingMentor;
use App\Models\JobTrainingTitle;
use App\Models\JobTrainingTitleStatus;
use App\Models\Logbook;
use App\Models\MentoringJobTraining;
use App\Models\MentoringStatus;
use App\Models\ReplyLetter;
use App\Models\ReplyLetterStatus;
use App\Models\SubmissionJobTraining;
use App\Models\SubmissionReport;
use App\Models\SubmissionStatus;
use App\Models\User;
use Illuminate\Http\Request;

class JobTrainingController extends Controller
{
    public function index(){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();

        $data =[
            'lastSubmission' => Null,
            'submissionStatus' => Null,
            'logbooks' => Null,
            'statusSubmission' => Null,
            'queueSubmissions'=>Null,
            'studentJobTrainingTitleHistory'=>Null,
            'studentJobTrainingTitleHistoryStatus' => Null,
            'historyQueueSubmissions' => Null,
            'queueSubmissionStatus'=> Null,
            'newLetters' => Null,
            'historyLetters' => Null,
            'historyLettersStatus' => Null,
            'chooseMentor' => Null,
            'academicYear' => Null,
            'mentors' => Null,
            'haveMentor'=>Null,
            'addMentoring' => Null,
            'allStudents' => Null,
            'mentoringQueue' => Null,
            'lecturerMentoringHistory' => Null,
            'lecturerMentoringHistoryStatus' => Null,
            'jobTrainingTitles'=>Null,
            'studentMentoringHistory' =>Null,
            'studentMentoringHistoryStatus' => Null,
            'reportHistory' => Null,
            'reportQueue' => Null,
        ];


        // jika user adalah admin
        if(auth()->user()->role_id == 1){
            // mengambil semua data yang sudah mengajukan
            $queueSubmissions = SubmissionJobTraining::where([
                'submission_status_id' => 9,
                'academic_year_id' => $academicYear->id,
            ])->get();
            if(count($queueSubmissions) > 0){
                $data['queueSubmissions'] = $queueSubmissions;
            }

            // mengambil history semua data yang sudah mengajukan
            $historyQueueSubmissions = SubmissionJobTraining::where([
                'academic_year_id' => $academicYear->id,
            ])->get();
            if(count($historyQueueSubmissions) > 0){
                $data['historyQueueSubmissions'] = $historyQueueSubmissions;
            }

            // mengambil semua data status submission
            $queueSubmissionStatus = SubmissionStatus::get();
                $data['queueSubmissionStatus'] = $queueSubmissionStatus;

            // mengambil data surat jurusan yang baru diajukan
            $newLetters = ReplyLetter::where([
                'academic_year_id' => $academicYear->id,
                'reply_letter_status_id' => 1,
            ])->get();
            if(count($newLetters) > 0){
                $data['newLetters'] = $newLetters;
            }

            // mengambil seluruh history pengajuan surat jurusan
            $historyLetters = ReplyLetter::where([
                'academic_year_id' => $academicYear->id,
            ])->get();
            $data['historyLetters'] = $historyLetters;

            // mengambil status pada pengajuan surat jurusan
            $historyLettersStatus = ReplyLetterStatus::get();
            $data['historyLettersStatus'] = $historyLettersStatus;
            
            // mengambil KP yang belum dapet dospem
            $chooseMentor = SubmissionJobTraining::where([
                'submission_status_id' => 14,
                'academic_year_id' => $academicYear->id,
            ])->get();
            if(count($chooseMentor) > 0){
                $data['chooseMentor'] = $chooseMentor;
            }

            // mengambil nama nama dosen
            $mentors = User::where([
                'role_id' => 2,
                'active_id' => 1,
            ])->get();
            if(count($mentors) > 0){
                $data['mentors'] = $mentors;
            }

            // mengambil data mahasiswa mana yang sudah dapat dospem
            $haveMentor = JobTrainingMentor::where([
                'academic_year_id' => $academicYear->id,
            ])->get();
            if(count($haveMentor) > 0){
                $data['haveMentor'] = $haveMentor;
            }

        }


        // jika user adalah dosen 
        elseif(auth()->user()->role_id == 2){
            // Mengambil daftar mahasiswa KP yang dibimbing
            $allStudents = JobTrainingMentor::where(['academic_year_id' => $academicYear->id, 'lecturer_id' => auth()->user()->id])->get();
            if(count($allStudents) > 0){
                $data['allStudents'] = $allStudents;
            }

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

            // ambil data bimbingan keseluruhan
            $lecturerMentoringHistory = MentoringJobTraining::where(['lecturer_id' => auth()->user()->id, 'academic_year_id' => $academicYear->id])->get();
            if(count($lecturerMentoringHistory) > 0){
                $data['lecturerMentoringHistory'] = $lecturerMentoringHistory;
            }

            // mengambil statusnya
            $lecturerMentoringHistoryStatus = MentoringStatus::get();
            $data['lecturerMentoringHistoryStatus'] = $lecturerMentoringHistoryStatus;

            // ambil data pengajuan judul
            $jobTrainingTitles = JobTrainingTitle::where(['lecturer_id'=>auth()->user()->id, 'academic_year_id' => $academicYear->id, 'job_training_title_status_id' => 1])->get();
            if(count($jobTrainingTitles) > 0){
                $data['jobTrainingTitles'] = $jobTrainingTitles;
            }

            // ambil data daftar antri revisi
            $reportQueue = SubmissionReport::where(['lecturer_id' => auth()->user()->id, 'academic_year_id' => $academicYear->id, 'submission_report_status_id'=>1])->get();
            if(count($reportQueue) > 0){
                $data['reportQueue'] = $reportQueue;
            }
        }


        // jika user adalah mahasiswa
        elseif(auth()->user()->role_id == 3){
            $lastSubmission = SubmissionJobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' => $academicYear->id,
            ])->latest()->first();

            if ($lastSubmission){
                $data['lastSubmission'] = $lastSubmission;
                $data['submissionStatus'] = $lastSubmission->submission_status_id;  

                // mengambil seluruh keterangan status submision
                $statusSubmission = SubmissionStatus::get();
                $data['statusSubmission'] = $statusSubmission;
                
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
                $studentMentoringHistoryStatus = MentoringStatus::get();
                $data['studentMentoringHistoryStatus'] = $studentMentoringHistoryStatus;

                $reportHistory = SubmissionReport::where([
                    'student_id' => auth()->user()->id,
                    'academic_year_id' => $academicYear->id,
                ])->get();

                if(count($reportHistory) > 0){
                    $data['reportHistory'] = $reportHistory;
                }

                // ambil data history pengajuan judul
                $studentJobTrainingTitleHistory = JobTrainingTitle::where([
                    'student_id' => auth()->user()->id,
                    'academic_year_id' => $academicYear->id,
                ])->get();
                if(count($studentJobTrainingTitleHistory) > 0){
                    $data['studentJobTrainingTitleHistory'] = $studentJobTrainingTitleHistory;
                }

                // ambil statusnya
                $studentJobTrainingTitleHistoryStatus = JobTrainingTitleStatus::get();
                $data['studentJobTrainingTitleHistoryStatus'] = $studentJobTrainingTitleHistoryStatus;
            }
        }

        $data['academicYear'] = $academicYear->id;
        return view('kerja-praktik.index', $data);
    }
}
