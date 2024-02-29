<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('college.disciplines', function (Blueprint $table) {
            $table->dropColumn('discipline_type'); // Удаление старого столбца

            // Добавление нового столбца как внешнего ключа
            $table->unsignedBigInteger('discipline_type_id')->after('caption');
            $table->foreign('discipline_type_id')->references('id')->on('college.discipline_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('college.disciplines', function (Blueprint $table) {
            $table->dropForeign(['discipline_type_id']);
            $table->dropColumn('discipline_type_id');

            $table->string('discipline_type')->after('caption'); // Восстановление старого столбца при откате
        });
    }
};
