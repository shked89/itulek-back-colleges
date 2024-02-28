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
        Schema::create('college.qualifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('qualification_code');
            $table->bigInteger('speciality_id');
            $table->foreign('speciality_id')->references('id')->on('college.specialities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college.qualifications');
    }
};
