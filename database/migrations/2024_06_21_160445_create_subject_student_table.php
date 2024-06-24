<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectStudentTable extends Migration
{
    public function up()
    {
        Schema::create('student_subject', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->string('subject_code');
            $table->foreign('subject_code')->references('subject_code')->on('subjects')->onDelete('cascade');
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_subject');
    }
}
