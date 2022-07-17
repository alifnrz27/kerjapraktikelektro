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
        Schema::create('submission_after_presentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('academic_year_id');
            $table->string('evaluate_presentation');
            $table->string('evaluate_mentoring');
            $table->string('notes');
            $table->string('official_report');
            $table->string('report_rev');
            $table->string('description')->nullable();
            $table->foreignId('submission_after_presentation_status_id');
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
        Schema::dropIfExists('submission_after_presentations');
    }
};
