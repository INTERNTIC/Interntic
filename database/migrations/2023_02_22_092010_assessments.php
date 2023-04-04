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

        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->date('the_date');
            $table->time('enter_time')->nullable();
            $table->time('left_time')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('internship_request_id');
            $table->unique('the_date', 'internship_request_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments');
    }
};
