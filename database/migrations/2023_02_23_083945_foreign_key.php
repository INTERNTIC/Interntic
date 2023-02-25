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
        Schema::table('department_heads', function (Blueprint $table){
           
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('students', function (Blueprint $table){
            $table->foreign('level_major_id')->references('id')->on('level_major')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('department_level', function (Blueprint $table){
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('internship_responssibles', function (Blueprint $table){
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');            
        });

        Schema::table('internship_requests', function (Blueprint $table){
            $table->foreign('student_id')->references('id')->on('students');   
        });

        Schema::table('department_refuses', function (Blueprint $table){
            $table->foreign('internship_request_id')->references('id')->on('internship_requests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('department_cause_id')->references('id')->on('department_causes')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('level_major', function (Blueprint $table){
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('studentcvs', function (Blueprint $table){
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('company_refuses', function (Blueprint $table){
            $table->foreign('internship_request_id')->references('id')->on('internship_requests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('company_causes_id')->references('id')->on('company_causes')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('internship_request_student', function (Blueprint $table){
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('internship_request_id')->references('id')->on('internship_requests')->onDelete('cascade')->onUpdate('cascade');      
        });

        Schema::table('assessments', function (Blueprint $table){
            $table->foreign('internship_request_student_id')->references('id')->on('internship_request_student')->onDelete('cascade')->onUpdate('cascade');      
        });

        Schema::table('offers', function (Blueprint $table){
            $table->foreign('internship_responsible_id')->references('id')->on('internship_responssibles')->onDelete('cascade')->onUpdate('cascade');      
        });
    
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
