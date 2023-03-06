<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentcvsTable extends Migration
{
   
    public function up()
    {
        Schema::create('student_cvs', function (Blueprint $table) {
            $table->id();
            $table->text('deatails');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('student_id');
           
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('student cvs');
    }
}
