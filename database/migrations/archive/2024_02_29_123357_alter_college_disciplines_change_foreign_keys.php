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
        // Убедитесь, что название таблицы и внешних ключей верны
        Schema::table('college.disciplines', function (Blueprint $table) {
            // Удаление существующего внешнего ключа
            $table->dropForeign(['department_id']); // Laravel автоматически генерирует имя внешнего ключа, если не указано явно
            // Добавление нового внешнего ключа
            $table->foreign('department_id')->references('id')->on('college.ref_department_to_discipline')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('college.disciplines', function (Blueprint $table) {
            // Восстановление оригинального внешнего ключа в случае отката миграции
            $table->dropForeign(['department_id']);
            $table->foreign('department_id')->references('id')->on('college.departments')->onDelete('cascade');
        });
    }
};
