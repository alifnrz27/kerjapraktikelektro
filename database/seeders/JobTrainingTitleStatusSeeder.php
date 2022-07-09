<?php

namespace Database\Seeders;

use App\Models\JobTrainingTitleStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTrainingTitleStatusSeeder extends Seeder
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
                'name' => 'Sedang diajukan',
            ],
            [
                'id'    => 2,
                'name' => 'Ditolak',
            ],
            [
                'id'    => 3,
                'name' => 'Diterima',
            ],
        ];

        JobTrainingTitleStatus::insert($status);
    }
}
