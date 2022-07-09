<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\beforePresentation;
use App\Models\SubmissionJobTraining;
use Illuminate\Http\Request;

class BeforePresentationController extends Controller
{
    public function add(Request $request){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        $request->validate([
            'company' => 'required',
            'form' => 'required',
            'logbook' => 'required',
        ]);

        // cek apakah logbook telah lengkap?
        
        // cek apakah sebelumnya masih mengajukan atau tidak, jika iya maka batalkan
        $check = beforePresentation::where([
            'academic_year_id' => $academicYear->id,
            'student_id' => auth()->user()->id,
            'before_presentation_status_id' => 1,
        ])->first();

        if($check){
            return back()->with('status', 'Menunggu pengajuan sebelumnya');
        }


        beforePresentation::create([
            'student_id' => auth()->user()->id,
            'company' => $request->company,
            'form' => $request->form,
            'logbook'=> $request->logbook,
            'academic_year_id' => $academicYear->id,
            'before_presentation_status_id' => 1,
        ]);

        SubmissionJobTraining::where([
            'user_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 18,
        ])->update([
            'submission_status_id' => 19,
        ]);
        return back()->with('status', 'Berhasil mengajukan berkas');
    }

    public function accept(Request $request, $studentID, $id){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = beforePresentation::where([
            'academic_year_id' => $academicYear->id,
            'student_id' => $studentID,
            'id' => $id,
            'before_presentation_status_id' => 1,
        ])->first();
        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        beforePresentation::where([
            'student_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'before_presentation_status_id' => 1,
        ])->update([
            'before_presentation_status_id' => 3,
        ]);

        SubmissionJobTraining::where([
            'user_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 19,
        ])->update([
            'submission_status_id' => 21,
        ]);

        return back()->with('status', 'Berhasil menerima berkas');
    }

    public function decline(Request $request, $studentID, $id){
        $request->validate([
            'description' => 'required',
        ]);
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = beforePresentation::where([
            'academic_year_id' => $academicYear->id,
            'student_id' => $studentID,
            'id' => $id,
            'before_presentation_status_id' => 1,
        ])->first();
        if(!$check){
            return back()->with('status', 'Data tidak ditemukan');
        }

        beforePresentation::where([
            'student_id' => $studentID,
            'academic_year_id' => $academicYear->id,
            'before_presentation_status_id' => 1,
        ])->update([
            'before_presentation_status_id' => 2,
            'description' => $request->description,
        ]);

        SubmissionJobTraining::where([
            'user_id' => auth()->user()->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 19,
        ])->update([
            'submission_status_id' => 20,
        ]);

        return back()->with('status', 'Berhasil menolak berkas');
    }
}
