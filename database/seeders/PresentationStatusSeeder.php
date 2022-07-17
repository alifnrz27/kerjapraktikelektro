<?php

namespace Database\Seeders;

use App\Models\PresentationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresentationStatusSeeder extends Seeder
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
                'name' => 'sudah dilaksanakan',
            ],
        ];

        PresentationStatus::insert($status);
    }
}
