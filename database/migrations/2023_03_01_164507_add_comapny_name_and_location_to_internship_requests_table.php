<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('internship_requests', function (Blueprint $table) {
            $table->string('company_name');
            $table->string('company_location'); 
        });
    }

    public function down()
    {
        Schema::table('internship_requests', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->dropColumn('company_location'); 
        });
    }
};