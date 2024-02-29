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
        Schema::create('college.ref_speciality_department_college', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('speciality_id');
            $table->foreign('speciality_id')->references('id')->on('college.specialities')->onDelete('cascade');
            $table->bigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('college.departments')->onDelete('cascade');
            $table->bigInteger('college_id');
            $table->foreign('college_id')->references('id')->on('college.colleges')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_ref_speciality_department_college');
    }
};
