<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $semester = [
            [
                'id'    => 1,
                'name' => 'Ganjil',
            ],
            [
                'id'    => 2,
                'name' => 'Genap',
            ],
        ];

        Semester::insert($semester);
    }
}
