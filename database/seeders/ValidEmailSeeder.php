<?php

namespace Database\Seeders;

use App\Models\ValidEmail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValidEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $validEmail = [
            [
                'id'    => 1,
                'name' => 'student.itera.ac.id',
            ],
            [
                'id'    => 2,
                'name' => 'el.itera.ac.id',
            ],
        ];

        ValidEmail::insert($validEmail);
    }
}
