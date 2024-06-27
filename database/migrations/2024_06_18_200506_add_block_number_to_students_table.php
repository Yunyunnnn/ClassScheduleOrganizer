<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('block_number')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('block_number');
        });
    }
};