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
        Schema::create('college.ref_person_disciplines', function (Blueprint $table) {
            $table->id();
            $table->string('caption');
            $table->unsignedBigInteger('discipline_id');
            $table->unsignedBigInteger('person_id');
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
        Schema::dropIfExists('college.ref_person_disciplines');
    }
};
