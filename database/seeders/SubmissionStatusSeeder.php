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
                'name' => 'Menuggu terima undangan anggota',
            ],
            [
                'id'    => 3,
                'name' => 'Mendapat undangan tim',
            ],
            [
                'id'    => 4,
                'name' => 'Menerima undangan tim',
            ],
            [
                'id'    => 5,
                'name' => 'Menolak Undangan',
            ],
            [
                'id'    => 6,
                'name' => 'Menuggu tim upload berkas',
            ],
            [
                'id'    => 7,
                'name' => 'Mahasiswa membatalkan pengajuan',
            ],
            [
                'id'    => 8,
                'name' => 'Anggota tim membatalkan pengajuan',
            ],
            [
                'id'    => 9,
                'name' => 'Tendik membatalkan pengajuan',
            ],
            [
                'id'    => 10,
                'name' => 'Berkas awal diterima',
            ],
            [
                'id'    => 11,
                'name' => 'Pengajuan baru dari jurusan',
            ],
            [
                'id'    => 12,
                'name' => 'Berkas jurusan di tolak',
            ],
            [
                'id'    => 13,
                'name' => 'KP diterima',
            ],
            [
                'id'    => 14,
                'name' => 'Menunggu seluruh anggota tim diterima admin',
            ],
            [
                'id'    => 15,
                'name' => 'Sudah dapat dosen pembimbing',
            ],
            [
                'id'    => 16,
                'name' => 'Selesai bimbingan dan Tidak ada revisi laporan',
            ],
            [
                'id'    => 17,
                'name' => 'Berkas pra-presentasi diajukan, menunggu admin',
            ],
            [
                'id'    => 18,
                'name' => 'Berkas pra-presentasi ditolak, ajukan ulang',
            ],
            [
                'id'    => 19,
                'name' => 'Berkas pra-presentasi diterima',
            ],
            [
                'id'    => 20,
                'name' => 'Mengajukan presentasi',
            ],
            [
                'id'    => 21,
                'name' => 'Presentasi sudah dijadwalkan',
            ],
            [
                'id'    => 22,
                'name' => 'Sudah presentasi',
            ],
        ];

        SubmissionStatus::insert($submissionStatus);
    }
}
