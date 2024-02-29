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
        Schema::table('college.departments', function (Blueprint $table) {
            // Добавляем столбец college_id и указываем, что это внешний ключ, связанный с таблицей colleges
            $table->unsignedBigInteger('college_id')->after('id'); // Используйте unsignedBigInteger для согласованности с типом поля id в Laravel
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
        Schema::table('college.departments', function (Blueprint $table) {
            // Удаляем внешний ключ и столбец college_id при откате миграции
            $table->dropForeign(['college_id']);
            $table->dropColumn('college_id');
        });
    }
};
