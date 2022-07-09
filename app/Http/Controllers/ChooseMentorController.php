<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\JobTrainingMentor;
use App\Models\SubmissionJobTraining;
use App\Models\User;
use Illuminate\Http\Request;

class ChooseMentorController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $student)
    {
        $academicYear = AcademicYear::where(['is_active'=>1])->first();
        $request->validate(['mentor' => 'required']);

        // cek apakah dosen ada, takutnya diubah di inspect elemen
        $mentor = User::where(['username' => $request->mentor, 'role_id' => 2, 'active_id' => 1])->first();
        // cek apakah dosen ada, takutnya diubah di inspect elemen
        $student = User::where(['username' => $student, 'role_id' => 3, 'active_id' => 1])->first();
        if(!$mentor || $student->role_id != 3 || $student->active_id != 1){
            return back()->with('status', 'Tidak ada user');// salah user
        }

        // cek apakah benar student belum mendapatkan mentor
        $submission = SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 14,
        ])->first();

        if(!$submission){
            return back()->with('status', 'Tidak ada data');// ga ditemukan submissionnnya
        }

        JobTrainingMentor::create([
            'student_id'=>$student->id,
            'lecturer_id' => $mentor->id,
            'academic_year_id' => $academicYear->id,
        ]);
        SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 14,
        ])->update(['submission_status_id'=>15]);

        return back()->with('status', 'Berhasil menambahkan data');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $student, $id)
    {
        $academicYear = AcademicYear::where(['is_active' => 1])->first();

        // cek apakah dosen ada, takutnya diubah di inspect elemen
        $mentor = User::where(['username' => $request->mentor, 'role_id' => 2, 'active_id' => 1])->first();
         // cek apakah dosen ada, takutnya diubah di inspect elemen
         $student = User::where(['username' => $student, 'role_id' => 3, 'active_id' => 1])->first();
        if(!$mentor || !$student || $student->role_id != 3 || $student->active_id != 1){
            return back()->with('status', 'Tidak ada user');// salah user
        }

        // cek apakah ada student dan mentor di semester yang sama
        $checkMentor = JobTrainingMentor::where(['student_id' => $student->id, 'academic_year_id' => $academicYear->id, 'id' => $id])->first();
        if(!$checkMentor){
            return back()->with('status', 'Gagal menambahkan, data sudah ada!');
        }

        // cek apakah benar student sudah mendapatkan mentor
        $submission = SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 15,
        ])->first();
        if(!$submission){
            return back()->with('status', 'Mahasiswa tidak ditemukan');// ga ditemukan submissionnnya
        }

        // jika ada maka ubah data mentornya
        JobTrainingMentor::where([
            'student_id' => $student->id, 
            'academic_year_id' => $academicYear->id, 
            'id' => $id,
            ])->update(['lecturer_id' => $mentor->id]);

            return back()->with('status', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($student, $id)
    {
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        
         // cek apakah dosen ada, takutnya diubah di inspect elemen
         $student = User::where(['username' => $student, 'role_id' => 3, 'active_id' => 1])->first();
        if(!$student || $student->role_id != 3 || $student->active_id != 1){
            return back()->with('status', 'Dosen tidak ada');// salah user
        }

        // cek apakah ada student dan mentor di semester yang sama
        $checkMentor = JobTrainingMentor::where(['student_id' => $student->id, 'academic_year_id' => $academicYear->id, 'id' => $id])->first();
        if(!$checkMentor){
            return back()->with('status', 'Data tidak ada');
        }

        // cek apakah benar student sudah mendapatkan mentor
        $submission = SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 15,
        ])->first();
        if(!$submission){
            return back()->with('status', 'Mahasiswa tidak ada');// ga ditemukan submissionnnya
        }

        // jika semua aman
        JobTrainingMentor::where(['student_id' => $student->id, 'academic_year_id' => $academicYear->id])->delete(); 
        SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 15,
        ])->update(['submission_status_id'=>14]);

        return back()->with('status', 'Berhasil menghapus data');
    }
}
