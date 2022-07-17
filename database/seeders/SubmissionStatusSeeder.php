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
                'name' => 'Menuggu seluruh anggota tim menerima undangan',
            ],
            [
                'id'    => 2,
                'name' => 'Anda mendapat undangan tim',
            ],
            [
                'id'    => 3,
                'name' => 'Anda menolak undangan',
            ],
            [
                'id'    => 4,
                'name' => 'Anda menerima undangan, lengkapi berkas',
            ],
            [
                'id'    => 5,
                'name' => 'Menunggu seluruh anggota tim upload berkas',
            ],
            [
                'id'    => 6,
                'name' => 'Anda membatalkan pengajuan',
            ],
            [
                'id'    => 7,
                'name' => 'Anggota tim membatalkan pengajuan',
            ],
            [
                'id'    => 8,
                'name' => 'Tendik menolak/membatalkan pengajuan',
            ],
            [
                'id'    => 9,
                'name' => 'Tendik sedang memeriksa',
            ],
            [
                'id'    => 10,
                'name' => 'Berkas awal diterima, upload berkas jurusan dan balasan instansi',
            ],
            [
                'id'    => 11,
                'name' => 'Mengnuggu seluruh berkas anggota tim diterima',
            ],
            [
                'id'    => 12,
                'name' => 'Tendik memeriksa berkas jurusan',
            ],
            [
                'id'    => 13,
                'name' => 'Surat jurusan ditolak Tendik',
            ],
            [
                'id'    => 14,
                'name' => 'KP diterima',
            ],
            [
                'id'    => 15,
                'name' => 'Sudah dapat dosen wali',
            ],
            [
                'id'    => 16,
                'name' => 'Judul sedang diajukan',
            ],
            [
                'id'    => 17,
                'name' => 'Judul ditolak',
            ],
            [
                'id'    => 18,
                'name' => 'Judul diterima',
            ],
            [
                'id'    => 19,
                'name' => 'Tendik memeriksa berkas sebelum presentasi',
            ],
            [
                'id'    => 20,
                'name' => 'Berkas ditolak, upload ulang!',
            ],
            [
                'id'    => 21,
                'name' => 'Berkas diterima',
            ],
            [
                'id'    => 22,
                'name' => 'Sedang mengajukan presentasi',
            ],
            [
                'id'    => 23,
                'name' => 'Presentasi diterima, semoga sukses!!!',
            ],
            [
                'id'    => 24,
                'name' => 'Presentasi telah dilaksanakan',
            ],
            [
                'id'    => 25,
                'name' => 'Sudah dinilai',
            ],
            [
                'id'    => 26,
                'name' => 'Menunggu tendik memeriksa berkas pasca presentasi',
            ],
            [
                'id'    => 27,
                'name' => 'Berkas pasca presentasi ditolak, upload ulang!',
            ],
            [
                'id'    => 28,
                'name' => 'Berkas pasca presentasi diterima',
            ],
            [
                'id'    => 29,
                'name' => 'Hardcopy telah dikumpulkan',
            ],
        ];

        SubmissionStatus::insert($submissionStatus);
    }
}
