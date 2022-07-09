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
        $submissionStatus = 9;
        $teamID = 0;
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        $rules = [
            'form' => 'required',
            'vaccine' => 'required',
            'name_leader' => 'required',
            'address' => 'required',
            'number' => 'required',
            'transcript' => 'required',
            'place' => 'required',
            'start' => 'required',
            'end' => 'required',
        ];
        if($request->addTeam == 'on'){
            $rules['teamMember'] = 'required';
        }   

        $request->validate($rules);

        // cek apakah jumlah hari awal ke akhir minus apa tidak, kalau minus gagal daftar
        $dateStart = strtotime($request->start);
        $dateEnd = strtotime($request->end);
        $now = strtotime('now +7 hours');
        if(($dateEnd - $dateStart) <= 0){
            return back()->with('status', 'Tanggal yang dimasukkan salah');
        }

        // jika tanggal mulai ternyata sudah lewat
        if(($dateStart - $now) <= 0){
            return back()->with('status', 'Tanggal mulai sudah lewat');
        }

        // jika input kurang dari 30 hari
        if(($dateEnd - $dateStart) < (strtotime('now +30 days 7 hours') - $now)){
            return back()->with('status', 'Minimal pengajuan 30 Hari!');
        }

        //check team member
        if ($request->addTeam == 'on'){
            $submissionStatus = 1;
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
                    return back()->with('status', 'Anggota tim tidak ditemukan!'); 
                }

                // jika user menginvite diri sendiri
                if($user->username == auth()->user()->username){
                    return back()->with('status', 'Tidak bisa invite diri sendiri!');
                }
            }

            // isi tabel team berdasarkan id ketua tim
            Team::create([
                'user_id'=>auth()->user()->id,
            ]);
            $team = Team::where('user_id', auth()->user()->id)->latest()->first();
            $teamID = $team->id;

            // tambahkan data anggota
            foreach($members as $member){
                $user = User::where([
                    'username' => $member,
                    'role_id'  => 3,
                    'active_id' => 1,
                    'inviteable' =>1
                ])->first();
                SubmissionJobTraining::create([
                    'user_id'=>$user->id,
                    'team_id'=>$team->id,
                    'name_leader' => $request->name_leader,
                    'address' => $request->address,
                    'number' => $request->number,
                    'place'=>$request->place,
                    'start'=>$request->start,
                    'end'=>$request->end,
                    'academic_year_id'=>$academicYear->id,
                    'submission_status_id'=>2,
                ]);
                User::where('username', $member)
                        ->update(['inviteable' => 0]);
            }
        }

        // isi data untuk ketua
        $validatedData = [
            'user_id'=>auth()->user()->id,
            'team_id'=>$teamID,
            'place'=>$request->place,
            'name_leader' => $request->name_leader,
            'address' => $request->address,
            'number' => $request->number,
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

        return back()->with('status', 'Sukses menambahkan');
    }

    public function uploadMemberSubmission(Request $request){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        $rules = [
            'form' => 'required',
            'vaccine' => 'required',
            'transcript' => 'required',
        ];

        $validated = $request->validate($rules);

        $lastSubmission = SubmissionJobTraining::where('user_id', auth()->user()->id)->latest()->first();

        SubmissionJobTraining::where('id' , $lastSubmission->id)
              ->update([
                'form'=>$request->form,
                'vaccine'=>$request->vaccine,
                'transcript'=>$request->transcript,
                'submission_status_id'=>5,
            ]);

            // mengambil data submission se tim yang belum acc undangan
            $invitedSubmission = SubmissionJobTraining::where(['team_id'=>$lastSubmission->team_id, 'submission_status_id' => 2])->get();

            // kalo udah gaada yg diundang lagi
            if (count($invitedSubmission) == 0){
                // ubah ketua jadi menunggu berkas seluruh anggota
                SubmissionJobTraining::where(['team_id'=> $lastSubmission->team_id, 'submission_status_id'=> 1])
                        ->update(['submission_status_id' => 5]);
                // mengambil data anggota yang sudah acc tapi belum upload
                $acceptedSubmission = SubmissionJobTraining::where(['team_id'=>$lastSubmission->team_id, 'submission_status_id' => 4])->get();

                // kalo yg nerima undangan pada udah upload semua
                if(count($acceptedSubmission) == 0){
                    SubmissionJobTraining::where(['team_id'=> $lastSubmission->team_id, 'submission_status_id'=> 5])
                    ->update(['submission_status_id' => 9]);
                }
            }   
            return back()->with('status', 'Sukses menambahkan data');
    }

    public function acceptSubmission(Request $request, User $user, SubmissionJobTraining $submission){

        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada submissionnya, takutnya malah diubah di inspect elemen
        $checkSubmission = SubmissionJobTraining::where([
            'user_id' => $user->id,
            'id' => $submission->id,
            'submission_status_id' => 9, //status sedang mengajukan
            'academic_year_id' => $academicYear->id
        ])->first();

        if(!$checkSubmission){
            return back()->with('status', 'mahasiswa tidak ditemukan');
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
                'submission_status_id' => 11
            ]);

            // cek jika seluruh anggota sudah di acc
            $teamSubmissions = SubmissionJobTraining::where([
                'team_id' => $submission->team_id
            ])->get();
            $waitingTeam = false;
            foreach($teamSubmissions as $submission){
                if($submission->submission_status_id == 9){
                    $waitingTeam = true;
                }
            }
            if($waitingTeam == false){
                SubmissionJobTraining::where([
                    'team_id' => $submission->team_id,
                    'submission_status_id' => 11
                ])->update([
                    'submission_status_id' => 10
                ]);
            }
        }
        return back()->with('status', 'sukses merubah data');
    }

    public function declineSubmission(Request $request, User $user, SubmissionJobTraining $submission){

        $rules = [
            'description' => 'required',
        ];

        $validated = $request->validate($rules);

        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada submissionnya, takutnya malah diubah di inspect elemen
        $checkSubmission = SubmissionJobTraining::where([
            'id' => $submission->id,
            'user_id' => $user->id,
            'submission_status_id' => 9, //status sedang mengajukan
            'academic_year_id' => $academicYear->id
        ])->first();

        if(!$checkSubmission){
            return back()->with('status', 'Data tidak ditemukan');
        }

        // jika dia tidak berkelompok ubah status menjadi ditolak admin
        if($submission->team_id == 0){
            SubmissionJobTraining::where([
                'id' => $submission->id
                ])->update([
                    'submission_status_id' => 8,
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
                    'submission_status_id' => 9,
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
                'submission_status_id' => 9,
            ])->update([
                'submission_status_id' => 8,
                'description' => $request->description,
            ]);


        }
        return back()->with('status', 'Data ditolak');
    }
}
