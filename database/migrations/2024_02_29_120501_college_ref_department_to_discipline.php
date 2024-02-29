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
        Schema::create('college.ref_department_to_discipline', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('college.departments')->onDelete('cascade');
            $table->bigInteger('discipline_id');
            $table->foreign('discipline_id')->references('id')->on('college.disciplines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_ref_department_to_discipline');
    }
};
