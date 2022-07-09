<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ReplyLetter;
use App\Models\SubmissionJobTraining;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class SubmissionLetterController extends Controller
{
    public function upload(Request $request){
        $submission = SubmissionJobTraining::where('user_id', auth()->user()->id)->latest()->first();
        $academicYear = AcademicYear::where(['is_active' => 1])->first();

        $rules = [
            'replyFromMajor' => 'required',
            'replyFromCompany' => 'required',
        ];

        $validated = $request->validate($rules);
        // jika tidak ada kelompok
        if($submission->team_id == 0){
            $validatedData = [
                'user_id' =>auth()->user()->id,
                'team_id'=>0,
                'academic_year_id'=>$academicYear->id,
                'from_major' => $request->replyFromMajor,
                'from_company' => $request->replyFromCompany,
                'reply_letter_status_id'=>1
            ];
            ReplyLetter::create($validatedData);
            SubmissionJobTraining::where('id', $submission->id)
            ->update(['submission_status_id' => 12]);
        }

        // jika ada kelompok
        else{
            $validatedData = [
                'user_id' =>auth()->user()->id,
                'team_id'=>$submission->team_id,
                'academic_year_id'=>$academicYear->id,
                'from_major' => $request->replyFromMajor,
                'from_company' => $request->replyFromCompany,
                'reply_letter_status_id'=>1
            ];
            ReplyLetter::create($validatedData);
            
            SubmissionJobTraining::where(['team_id'=> $submission->team_id, 'submission_status_id'=>10])
            ->update(['submission_status_id' => 12]);
        }

        return back()->with('status', 'Berhasil upload berkas jurusan');
    }

    public function acceptLetter(Request $request, User $user, $team_id){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek keberadaan data, takutnya diubah dari inspect element
        $checkLetter = ReplyLetter::where([
            'team_id' => $team_id,
            'user_id' => $user->id,
            'reply_letter_status_id' => 1,
            'academic_year_id' => $academicYear->id
        ])->first();

        if(!$checkLetter){
            return back()->with('status', 'Data tidak ditemukan');
        }

        ReplyLetter::where([
            'id'=>$checkLetter->id
        ])->update([
            'reply_letter_status_id' => 3
        ]);

        // jika tidak berkelompok
        if($checkLetter->team_id == 0){
            SubmissionJobTraining::where([
                'user_id' => $checkLetter->user_id,
                'submission_status_id' => 12,
            ])->update([
                'submission_status_id' => 14,
            ]);
        }

        // jika berkelompok
        else{
            SubmissionJobTraining::where([
                'team_id' => $checkLetter->team_id,
                'submission_status_id' => 12,
            ])->update([
                'submission_status_id' => 14,
            ]);
        }

        return back()->with('status', 'Berhasil menerima data');
    }

    public function declineLetter(Request $request, User $user, $team_id){
        $academicYear = AcademicYear::where(['is_active'=>1])->first();

        // cek keberadaan data, takutnya diubah dari inspect element
        $checkLetter = ReplyLetter::where([
            'team_id' => $team_id,
            'user_id' => $user->id,
            'reply_letter_status_id' => 1,
            'academic_year_id' => $academicYear->id
        ])->first();

        if(!$checkLetter){
            return back()->with('status', 'Data tidak ditemukan');
        }

        ReplyLetter::where([
            'id'=>$checkLetter->id
        ])->update([
            'reply_letter_status_id' => 2
        ]);

        // jika tidak berkelompok
        if($checkLetter->team_id == 0){
            SubmissionJobTraining::where([
                'user_id' => $checkLetter->user_id,
                'submission_status_id' => 12,
            ])->update([
                'submission_status_id' => 13,
                'description' => $request->description,
            ]);

        }

        // jika berkelompok
        else{
            SubmissionJobTraining::where([
                'team_id' => $checkLetter->team_id,
                'submission_status_id' => 11,
            ])->update([
                'submission_status_id' => 12,
                'description' => $request->description,
            ]);
        }
        return back()->with('status', 'Berhasil menolak surat');
    }
}
