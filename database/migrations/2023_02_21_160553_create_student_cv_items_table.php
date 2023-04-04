<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('student_cv_items', function (Blueprint $table) {
            $table->id();
            $table->text('deatails');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('student_id');
           
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('student cv_items');
    }
};