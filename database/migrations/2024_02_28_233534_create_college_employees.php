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
        Schema::create('college.employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('person_id');
            $table->bigInteger('college_id');
            $table->foreign('college_id')->references('id')->on('college.colleges')->onDelete('cascade');
            $table->bigInteger('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college.employees');
    }
};
