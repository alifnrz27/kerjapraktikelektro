<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function input(Request $request){
        $rules = [
            'date' => 'required',
            'description' => 'required',
        ];
        $validated = $request->validate($rules);

        $submission = SubmissionJobTraining::where('user_id', auth()->user()->id)->get();
        $countSubmission = count($submission);
        $submission = $submission[$countSubmission-1];

        $logbooks = Logbook::where(['user_id' => auth()->user()->id, 'submission_job_training_id' => $submission->id])->get();
        if (count($logbooks) > 0){
            $countLogbook = count($logbooks);
            $logbook = $logbooks[$countLogbook-1];
        }

        $inputDate = strtotime($request->date);
        $startDate = strtotime($submission->start);
        $endDate = strtotime($submission->end);
        $now = strtotime('now +7 hours');
        
        // jika tanggal di luar rentang waktu yang ditentukan
        if ($inputDate < $startDate || $inputDate > $endDate ){
            return abort(403);// tanggal yang diinput di luar rentang
        }

        // jika user memasukkan tanggal yang belum dilalui
        if($inputDate > $now){
            return abort(404); // selesaikan harimu, baru input data
        }

        // jika user belum memasukkan data sebelum hari ini
        if(count($logbooks) == 0){
            // jika user belum memasukkan sama sekali logbook, namun sudah lompat ke tanggal lain
            if($inputDate >= strtotime($submission->start . ' +1 day')){
                return "belum isi hari pertama"; // kamu belum isi logbook hari pertama
            }
        }
        else{
            // jika user memasukkan tanggal, namun hari sebelumnya belum diinputkan
            if($inputDate > strtotime($logbook->date . ' +1 day')){
                return "isi logbook sebelumnya";// kamu belum isi logbook sebelumnya
            }
        }

        // jika user memasukkan logbook di tanggal yang sudah diinput
        foreach($logbooks as $logbook){
            if($logbook->date == $request->date){
                return 'kamu udah isi'; //kamu udah isi tcuy
            }
        }

        // isi tabel logbook
        Logbook::create([
            'user_id'=>auth()->user()->id,
            'submission_job_training_id' => $submission->id,
            'date'=>$request->date,
            'description'=>$request->description
        ]);
    }
}
