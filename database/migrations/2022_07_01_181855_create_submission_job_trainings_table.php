<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_job_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('team_id')->nullable();
            $table->string('place');
            $table->string('name_leader');
            $table->string('address');
            $table->string('number');
            $table->string('start');
            $table->String('end');
            $table->string('description')->nullable();
            $table->string('form')->nullable();
            $table->string('transcript')->nullable();
            $table->string('vaccine')->nullable();
            $table->foreignId('academic_year_id');
            $table->foreignId('submission_status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submission_job_trainings');
    }
};
