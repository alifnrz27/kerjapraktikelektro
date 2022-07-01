<?php

namespace Database\Seeders;

use App\Models\Active;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $active = [
            [
                'id'    => 1,
                'name' => 'Active',
            ],
            [
                'id'    => 2,
                'name' => 'Graduated',
            ],
            [
                'id'    => 3,
                'name' => 'Left',
            ],
        ];

        Active::insert($active);
    }
}
