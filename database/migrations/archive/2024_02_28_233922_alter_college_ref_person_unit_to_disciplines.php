<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('college.ref_person_disciplines', function (Blueprint $table) {
            // Предполагаем, что столбец person_id уже существует, добавляем внешний ключ
            $table->foreign('person_id')->references('id')->on('college.employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('college.ref_person_disciplines', function (Blueprint $table) {
            // Удаление внешнего ключа и оставление столбца без изменений
            $table->dropForeign(['person_id']);
        });
    }
};