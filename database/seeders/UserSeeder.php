<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'id'    => 1,
                'name' => 'admin',
                'username' => 'admin',
                'role_id' => 1,
                'email' => 'admin@el.itera.ac.id',
                'password' => bcrypt('12341234'),
            ],
            [
                'id'    => 2,
                'name' => 'dosen1',
                'username' => 'dosen1',
                'role_id' => 2,
                'email' => 'dosen1@el.itera.ac.id',
                'password' => bcrypt('12341234'),
            ],
            [
                'id'    => 3,
                'name' => 'dosen2',
                'username' => 'dosen2',
                'role_id' => 2,
                'email' => 'dosen2@el.itera.ac.id',
                'password' => bcrypt('12341234'),
            ],
            [
                'id'    => 4,
                'name' => 'mahasiswa1',
                'username' => 'mahasiswa1',
                'role_id' => 3,
                'email' => 'mahasiswa1@el.itera.ac.id',
                'password' => bcrypt('12341234'),
            ],
            [
                'id'    => 5,
                'name' => 'mahasiswa2',
                'username' => 'mahasiswa2',
                'role_id' => 3,
                'email' => 'mahasiswa2@el.itera.ac.id',
                'password' => bcrypt('12341234'),
            ],
        ];

        User::insert($user);
    }
}
