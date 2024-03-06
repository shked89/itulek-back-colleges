<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('college.ref_person_unit_to_departments', function (Blueprint $table) {
            // Удаление столбца person_unit_id
            $table->dropColumn('person_unit_id');

            // Добавление нового столбца person_id с внешним ключом
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('college.employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('college.ref_person_unit_to_departments', function (Blueprint $table) {
            // Добавляем обратно столбец person_unit_id при откате миграции
            $table->bigInteger('person_unit_id')->after('id');

            // Удаляем внешний ключ и столбец person_id
            $table->dropForeign(['person_id']);
            $table->dropColumn('person_id');
        });
    }
};