<?php

namespace Database\Seeders;

use App\Models\SubmissionStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmissionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $submissionStatus = [
            [
                'id'    => 1,
                'name' => 'Sudah diajukan pendaftaran',
            ],
            [
                'id'    => 2,
                'name' => 'Menuggu terima undangan',
            ],
            [
                'id'    => 3,
                'name' => 'Menolak Undangan',
            ],
            [
                'id'    => 4,
                'name' => 'Mahasiswa membatalkan pengajuan',
            ],
            [
                'id'    => 5,
                'name' => 'Ketua membatalkan pengajuan',
            ],
            [
                'id'    => 6,
                'name' => 'Tendik membatalkan pengajuan',
            ],
            [
                'id'    => 7,
                'name' => 'Berkas awal diterima',
            ],
            [
                'id'    => 8,
                'name' => 'Pengajuan baru dari jurusan',
            ],
            [
                'id'    => 9,
                'name' => 'KP diterima',
            ],
        ];

        SubmissionStatus::insert($submissionStatus);
    }
}
