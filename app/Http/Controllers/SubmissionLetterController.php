<?php

namespace App\Http\Controllers;

use App\Models\ReplyLetter;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class SubmissionLetterController extends Controller
{
    public function upload(Request $request){
        $submission = SubmissionJobTraining::where('user_id', auth()->user()->id)->get();
        $countSubmission = count($submission);
        $submission = $submission[$countSubmission-1];

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
                'from_major' => $request->replyFromMajor,
                'from_company' => $request->replyFromCompany
            ];
            ReplyLetter::create($validatedData);
            SubmissionJobTraining::where('id', $submission->id)
            ->update(['submission_status_id' => 11]);
        }

        // jika ada kelompok
        else{
            $validatedData = [
                'user_id' =>auth()->user()->id,
                'team_id'=>$submission->team_id,
                'from_major' => $request->replyFromMajor,
                'from_company' => $request->replyFromCompany
            ];
            ReplyLetter::create($validatedData);
            
            SubmissionJobTraining::where('team_id', $submission->team_id)
            ->update(['submission_status_id' => 11]);
        }
        // $validatedData = [
        //     'team_id'=>0,
        //         'from_major' => $request->replyFromMajor,
        //         'from_company' => $request->replyFromCompany
        // ];

        // SubmissionJobTraining::create($validatedData);
    }
}
