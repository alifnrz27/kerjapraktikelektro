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
        Schema::create('before_presentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->string('company');
            $table->string('form');
            $table->string('logbook');
            $table->string('description')->nullable();
            $table->foreignId('academic_year_id');
            $table->foreignId('before_presentation_status_id');
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
        Schema::dropIfExists('before_presentations');
    }
};
