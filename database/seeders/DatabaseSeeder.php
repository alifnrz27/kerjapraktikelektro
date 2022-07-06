<?php

namespace Database\Seeders;

use App\Models\SubmissionReportStatus;
use App\Models\ValidEmail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            ActiveSeeder::class,
            RoleSeeder::class,
            ValidEmailSeeder::class,
            SubmissionStatusSeeder::class,
            AcademicYearSeeder::class,
            SemesterSeeder::class,
            ReplyLetterStatusSeeder::class,
            MentoringStatusSeeder::class,
            SubmissionReportStatusSeeder::class,
        ]);
    }
}
