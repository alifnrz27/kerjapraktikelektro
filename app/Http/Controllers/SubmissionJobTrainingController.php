<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\SubmissionJobTraining;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class SubmissionJobTrainingController extends Controller
{
    public function uploadSubmission(Request $request){
        $submissionStatus = 1;
        $teamID = 0;
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        $rules = [
            'form' => 'required',
            'vaccine' => 'required',
            'transcript' => 'required',
            'place' => 'required',
            'start' => 'required',
            'end' => 'required',
        ];
        if($request->addTeam == 'on'){
            $rules['teamMember'] = 'required';
        }   

        $validated = $request->validate($rules);

        // cek apakah jumlah hari awal ke akhir minus apa tidak, kalau minus gagal daftar
        $dateStart = strtotime($request->start);
        $dateEnd = strtotime($request->end);
        $now = strtotime('now +7 hours');
        if(($dateEnd - $dateStart) <= 0){
            return abort(403); // tanggal salah
        }

        // jika tanggal mulai ternyata sudah lewat
        if(($dateStart - $now) <= 0){
            return abort(403); // tanggal mulai sudah lewat
        }

        // jika input kurang dari 30 hari
        if(($dateEnd - $dateStart) < (strtotime('now +30 days 7 hours') - $now)){
            return abort(403); // minimal 30 hari
        }

        //check team member
        if ($request->addTeam == 'on'){
            $submissionStatus = 2;
            $members = explode(' ', $request->teamMember);
            $members = array_unique($members);
            foreach($members as $member){
                $user = User::where([
                    'username' => $member,
                    'role_id'  => 3,
                    'active_id' => 1,
                    'inviteable' =>1
                ])->first();

                // ketika tidak ada usernya
                if(!$user){
                    return abort(404);  
                }

                // jika user menginvite diri sendiri
                if($user->username == auth()->user()->username){
                    return abort (403);
                }
            }

            // isi tabel team berdasarkan id ketua tim
            Team::create([
                'user_id'=>auth()->user()->id,
            ]);
            $team = Team::where('user_id', auth()->user()->id)->get();
            $countTeam = count($team);
            $team = $team[$countTeam-1];
            $teamID = $team->id;

            foreach($members as $member){
                $user = User::where([
                    'username' => $member,
                    'role_id'  => 3,
                    'active_id' => 1,
                    'inviteable' =>1
                ])->first();
                SubmissionJobTraining::create([
                    'user_id'=>$user->id,
                    'team_id'=>$teamID,
                    'place'=>$request->place,
                    'start'=>$request->start,
                    'end'=>$request->end,
                    'academic_year_id'=>$academicYear->id,
                    'submission_status_id'=>3,
                ]);
                User::where('username', $member)
                        ->update(['inviteable' => 0]);
            }
        }

        $validatedData = [
            'user_id'=>auth()->user()->id,
            'team_id'=>$teamID,
            'place'=>$request->place,
            'start'=>$request->start,
            'end'=>$request->end,
            'form'=>$request->form,
            'vaccine'=>$request->vaccine,
            'transcript'=>$request->transcript, 
            'academic_year_id'=>$academicYear->id,
            'submission_status_id'=>$submissionStatus,
        ];

        SubmissionJobTraining::create($validatedData);

        User::where('id', auth()->user()->id)
              ->update(['inviteable' => 0]);
        return 'awkaii';
    }

    public function uploadMemberSubmission(Request $request){
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        $rules = [
            'form' => 'required',
            'vaccine' => 'required',
            'transcript' => 'required',
        ];

        $validated = $request->validate($rules);

        $lastSubmission = SubmissionJobTraining::where('user_id', auth()->user()->id)->get();
        $countSubmission = count($lastSubmission);
        $lastSubmission = $lastSubmission[$countSubmission-1];

        SubmissionJobTraining::where('user_id', auth()->user()->id)
              ->update([
                'form'=>$request->form,
                'vaccine'=>$request->vaccine,
                'transcript'=>$request->transcript,
                'submission_status_id'=>6,
            ]);

        $leader = Team::where('id', $lastSubmission->team_id)->first();
        $allTeamSubmission = SubmissionJobTraining::where(['team_id'=>$lastSubmission->team_id])->get();
        $teamSubmission = [];
        if ($allTeamSubmission){
            for ($i = 0; $i<count($allTeamSubmission); $i++){
                if ($allTeamSubmission[$i]->submission_status_id == 6){
                    continue;
                }
                $teamSubmission[$i] = $allTeamSubmission[$i];
            }
        }
        // jika semua sudah upload berkas, maka seluruh tim ganti status jadi menunggu admin
        if (count($teamSubmission) == 0){
            // ganti status ketua
            $leaderSubmission = SubmissionJobTraining::where('user_id', $leader->user_id)->get();
            $countSubmission = count($leaderSubmission);
            $leaderSubmission = $leaderSubmission[$countSubmission-1];
            SubmissionJobTraining::where('team_id', $leaderSubmission->team_id)
        ->update(['submission_status_id' => 1]);
        }
    }

    public function acceptSubmission(Request $request, User $user, SubmissionJobTraining $submission){
        $currentSemester = AcademicYear::get();
        $countSemester = count($currentSemester);
        $currentSemester = $currentSemester[$countSemester-1];
        // cek apakah ada submissionnya, takutnya malah diubah di inspect elemen
        $checkSubmission = SubmissionJobTraining::where([
            'id' => $submission->id,
            'user_id' => $user->id,
            'submission_status_id' => 1, //status sedang mengajukan
            'academic_year_id' => $currentSemester->id
        ])->first();

        if(!$checkSubmission){
            return abort(403); // submission tidak ditemukan
        }


        // jika dia tidak berkelompok ubah status menjadi diterima
        if($submission->team_id == 0){
            SubmissionJobTraining::where([
                'id' => $submission->id
            ])->update([
                'submission_status_id' => 10
            ]);
        }

        // jika berkelompok ubah status menjadi menunggu anggota lain di acc
        else{
            SubmissionJobTraining::where([
                'id' => $submission->id
            ])->update([
                'submission_status_id' => 14
            ]);

            // cek jika seluruh anggota sudah di acc
            $teamSubmissions = SubmissionJobTraining::where([
                'team_id' => $submission->team_id
            ])->get();
            $waitingTeam = false;
            foreach($teamSubmissions as $submission){
                if($submission->submission_status_id == 1){
                    $waitingTeam = true;
                }
            }
            if($waitingTeam == false){
                SubmissionJobTraining::where([
                    'team_id' => $submission->team_id,
                    'submission_status_id' => 14
                ])->update([
                    'submission_status_id' => 10
                ]);
            }
        }
    }

    public function declineSubmission(Request $request, User $user, SubmissionJobTraining $submission){
        $rules = [
            'description' => 'required',
        ];

        $validated = $request->validate($rules);

        $currentSemester = AcademicYear::get();
        $countSemester = count($currentSemester);
        $currentSemester = $currentSemester[$countSemester-1];
        // cek apakah ada submissionnya, takutnya malah diubah di inspect elemen
        $checkSubmission = SubmissionJobTraining::where([
            'id' => $submission->id,
            'user_id' => $user->id,
            'submission_status_id' => 1, //status sedang mengajukan
            'academic_year_id' => $currentSemester->id
        ])->first();

        if(!$checkSubmission){
            return abort(403); // submission tidak ditemukan
        }

        // jika dia tidak berkelompok ubah status menjadi ditolak admin
        if($submission->team_id == 0){
            SubmissionJobTraining::where([
                'id' => $submission->id
                ])->update([
                    'submission_status_id' => 9,
                    'description' => $request->description,
                ]);
            User::where([
                    'id' => $submission->user_id
                    ])->update([
                        'inviteable' => 1,
                    ]);
        }

        // jika berkelompok ubah status menjadi ditolak beramai ramai
        else{
                // mendapatkan id masing masing anggota
                $members = SubmissionJobTraining::select('user_id')
                ->where([
                    'team_id' => $submission->team_id,
                    'submission_status_id' => 1,
                ])->get();
                $userID = [];
                for($i = 0; $i < count($members); $i++){
                    $userID[$i] = $members[$i]['user_id'];
                }

                User::whereIn('id', $userID)
                ->update([
                    'inviteable'=> 1
                ]);

            SubmissionJobTraining::where([
                'team_id' => $submission->team_id,
                'submission_status_id' => 1,
            ])->update([
                'submission_status_id' => 9,
                'description' => $request->description,
            ]);


        }
    }
}
