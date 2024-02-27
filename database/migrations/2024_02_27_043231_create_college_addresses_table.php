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
        Schema::create('college.college_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('college_id');
            $table->foreign('college_id')->references('id')->on('college.colleges')->onDelete('cascade');
            $table->string('country_name');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('college.cities')->onDelete('cascade');
            $table->string('address_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college.college_addresses');
    }
};
