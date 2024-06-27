<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleIdToStudentSubjectTable extends Migration
{
    public function up()
    {
        Schema::table('student_subject', function (Blueprint $table) {
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('student_subject', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
            $table->dropColumn('schedule_id');
        });
    }
}

