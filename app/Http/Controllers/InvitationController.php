<?php

namespace App\Http\Controllers;

use App\Models\SubmissionJobTraining;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function acceptInvitation(){
        $lastSubmission = SubmissionJobTraining::where('user_id', auth()->user()->id)->get();
        $countSubmission = count($lastSubmission);
        $lastSubmission = $lastSubmission[$countSubmission-1];

        // ganti status jadi menerima undangan
        SubmissionJobTraining::where('id', $lastSubmission->id)
        ->update(['submission_status_id' => 4]);

        //mendapatkan user id ketua
        $leader = Team::where('id', $lastSubmission->team_id)->first();
        // mengambil data submission se tim yang belum acc undangan
        $allTeamSubmission = SubmissionJobTraining::where(['team_id'=>$lastSubmission->team_id, 'submission_status_id' => 3])->get();
        $teamSubmission = [];
        if ($allTeamSubmission){
            for ($i = 0; $i<count($allTeamSubmission); $i++){
                if ($allTeamSubmission[$i]->user_id == $leader->user_id){
                    continue;
                }
                $teamSubmission[$i] = $allTeamSubmission[$i];
            }
        }
        // jika semua sudah menerima atau menolak undangan, maka ketua ganti status menjadi menunggu tim upload berkas
        if (!$teamSubmission){
            // ganti status ketua
            $leaderSubmission = SubmissionJobTraining::where('user_id', $leader->user_id)->get();
            $countSubmission = count($leaderSubmission);
            $leaderSubmission = $leaderSubmission[$countSubmission-1];
            SubmissionJobTraining::where('id', $leaderSubmission->id)
        ->update(['submission_status_id' => 6]);
        }
    }

    public function declineInvitation(){

        $lastSubmission = SubmissionJobTraining::where('user_id', auth()->user()->id)->get();
        $countSubmission = count($lastSubmission);
        $lastSubmission = $lastSubmission[$countSubmission-1];

        // ganti status jadi menolak undangan
        SubmissionJobTraining::where('id', $lastSubmission->id)
        ->update(['submission_status_id' => 5]);
        // ubah inviteable nya
        User::where('id', auth()->user()->id)->update(['inviteable'=>1]);

        //mendapatkan user id ketua
        $leader = Team::where('id', $lastSubmission->team_id)->first();
        // mengambil data submission se tim yang belum acc undangan
        $allTeamSubmission = SubmissionJobTraining::where(['team_id'=>$lastSubmission->team_id, 'submission_status_id' => 3])->get();
        $teamSubmission = [];
        if ($allTeamSubmission){
            for ($i = 0; $i<count($allTeamSubmission); $i++){
                if ($allTeamSubmission[$i]->user_id == $leader->user_id){
                    continue;
                }
                $teamSubmission[$i] = $allTeamSubmission[$i];
            }
        }
        // jika semua sudah menerima atau menolak undangan, maka ketua ganti status menjadi menunggu tim upload berkas
        if (!$teamSubmission){
            // ganti status ketua
            $leaderSubmission = SubmissionJobTraining::where('user_id', $leader->user_id)->get();
            $countSubmission = count($leaderSubmission);
            $leaderSubmission = $leaderSubmission[$countSubmission-1];
            SubmissionJobTraining::where('id', $leaderSubmission->id)
        ->update(['submission_status_id' => 6]);
        }
    }

    public function cancelSubmission(){
        $lastSubmission = SubmissionJobTraining::where('user_id', auth()->user()->id)->get();
        $countSubmission = count($lastSubmission);
        $lastSubmission = $lastSubmission[$countSubmission-1];

        // jika pengajuan individu
        if($lastSubmission->team_id == 0){
            SubmissionJobTraining::where('id', $lastSubmission->id)
        ->update(['submission_status_id' => 7]);
        User::where('id', auth()->user()->id)->update(['inviteable'=>1]);
        }
        // kalo dia berkelompok
        else {
            $allSubmissions = SubmissionJobTraining::where('team_id', $lastSubmission->team_id)->get();
            foreach($allSubmissions as $submission){
                SubmissionJobTraining::where('id', $submission->id)
        ->update(['submission_status_id' => 8]);
        User::where('id', $submission->user_id)->update(['inviteable'=>1]);
            }
        }
    }
}
