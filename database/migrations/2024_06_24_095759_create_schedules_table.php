<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id(); // Creates an unsigned big integer 'id'
            $table->string('subject_code');
            $table->foreign('subject_code')->references('subject_code')->on('subjects')->onDelete('cascade');
            $table->string('course');
            $table->string('block_number');
            $table->integer('year_level');
            $table->time('time_from');
            $table->time('time_to');
            $table->string('days_of_week');
            $table->string('room');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
