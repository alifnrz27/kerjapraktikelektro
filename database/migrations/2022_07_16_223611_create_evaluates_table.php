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
        Schema::create('evaluates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id');
            $table->foreignId('student_id');
            $table->foreignId('lecturer_id');
            $table->integer('understanding_score')->nullable();
            $table->integer('analysis_score')->nullable();
            $table->integer('report_score')->nullable();
            $table->string('description_mentoring')->nullable();
            $table->integer('presentation_score')->nullable();
            $table->integer('content_score')->nullable();
            $table->integer('qna_score')->nullable();
            $table->string('description_presentation')->nullable();
            $table->foreignId('evaluate_status_id');
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
        Schema::dropIfExists('evaluates');
    }
};
