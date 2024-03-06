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
        Schema::create('college.ref_person_unit_to_departments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('person_unit_id');
            $table->bigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('college.departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college.ref_person_unit_to_departments');
    }
};
