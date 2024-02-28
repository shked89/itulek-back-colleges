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
        Schema::create('college.disciplines', function (Blueprint $table) {
            $table->id();
            $table->string('caption');
            $table->string('discipline_type');
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
        Schema::dropIfExists('college.disciplines');
    }
};
