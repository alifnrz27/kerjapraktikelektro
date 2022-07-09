<?php

namespace Database\Seeders;

use App\Models\beforePresentationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeforePresentationStatusSeeder extends Seeder
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
                'name' => 'ditolak',
            ],
            [
                'id'    => 3,
                'name' => 'diterima',
            ],
        ];

        beforePresentationStatus::insert($status);
    }
}
