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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $student)
    {
        $request->validate(['mentor' => 'required']);

        // cek apakah dosen ada, takutnya diubah di inspect elemen
        $mentor = User::where(['username' => $request->mentor, 'role_id' => 2, 'active_id' => 1])->first();
        // cek apakah dosen ada, takutnya diubah di inspect elemen
        $student = User::where(['username' => $student, 'role_id' => 3, 'active_id' => 1])->first();
        if(!$mentor || $student->role_id != 3 || $student->active_id != 1){
            return 'wkwk';// salah user
        }

        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];

        // cek apakah benar student belum mendapatkan mentor
        $submission = SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 13,
        ])->first();

        if(!$submission){
            return abort(403);// ga ditemukan submissionnnya
        }

        JobTrainingMentor::create([
            'student_id'=>$student->id,
            'lecturer_id' => $mentor->id,
            'academic_year_id' => $academicYear->id,
        ]);
        SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 13,
        ])->update(['submission_status_id'=>15]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // cek apakah dosen ada, takutnya diubah di inspect elemen
        $mentor = User::where(['username' => $request->mentor, 'role_id' => 2, 'active_id' => 1])->first();
         // cek apakah dosen ada, takutnya diubah di inspect elemen
         $student = User::where(['username' => $student, 'role_id' => 3, 'active_id' => 1])->first();
        if(!$mentor || !$student || $student->role_id != 3 || $student->active_id != 1){
            return "wkwkwk";// salah user
        }

        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];

        // cek apakah ada student dan mentor di semester yang sama
        $checkMentor = JobTrainingMentor::where(['student_id' => $student->id, 'academic_year_id' => $academicYear->id, 'id' => $id])->first();

        if(!$checkMentor){
            return abort(403);
        }

        // cek apakah benar student sudah mendapatkan mentor
        $submission = SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 15,
        ])->first();

        if(!$submission){
            return abort(403);// ga ditemukan submissionnnya
        }

        // jika ada maka ubah data mentornya
        JobTrainingMentor::where([
            'student_id' => $student->id, 
            'academic_year_id' => $academicYear->id, 
            'id' => $id,
            ])->update(['lecturer_id' => $mentor->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($student, $id)
    {
        $academicYear = AcademicYear::get();
        $countAcademicYear = count($academicYear);
        $academicYear = $academicYear[$countAcademicYear-1];
        
         // cek apakah dosen ada, takutnya diubah di inspect elemen
         $student = User::where(['username' => $student, 'role_id' => 3, 'active_id' => 1])->first();

        if(!$student || $student->role_id != 3 || $student->active_id != 1){
            return "wkwkwk";// salah user
        }

        

        // cek apakah ada student dan mentor di semester yang sama
        $checkMentor = JobTrainingMentor::where(['student_id' => $student->id, 'academic_year_id' => $academicYear->id, 'id' => $id])->first();

        if(!$checkMentor){
            return abort(403);
        }

        // cek apakah benar student sudah mendapatkan mentor
        $submission = SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 15,
        ])->first();

        if(!$submission){
            return abort(403);// ga ditemukan submissionnnya
        }

        // jika semua aman
        JobTrainingMentor::where(['student_id' => $student->id, 'academic_year_id' => $academicYear->id])->delete(); 
        SubmissionJobTraining::where([
            'user_id' => $student->id,
            'academic_year_id' => $academicYear->id,
            'submission_status_id' => 15,
        ])->update(['submission_status_id'=>13]);
    }
}
