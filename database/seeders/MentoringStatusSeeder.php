<?php

namespace Database\Seeders;

use App\Models\MentoringStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MentoringStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'id'    => 1,
                'name' => 'diajukan',
            ],
            [
                'id'    => 2,
                'name' => 'ditolak/batal',
            ],
            [
                'id'    => 3,
                'name' => 'diterima',
            ],
            [
                'id'    => 4,
                'name' => 'selesai',
            ],
        ];

        MentoringStatus::insert($status);
    }
}
