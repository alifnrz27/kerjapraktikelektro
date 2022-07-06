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
        Schema::create('submission_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('lecturer_id');
            $table->string('report');
            $table->string('description');
            $table->foreignId('academic_year_id');
            $table->foreignId('submission_report_status_id');
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
        Schema::dropIfExists('submission_reports');
    }
};
