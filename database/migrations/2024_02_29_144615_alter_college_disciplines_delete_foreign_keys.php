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
        Schema::table('college.disciplines', function (Blueprint $table) {
            // Удаление внешнего ключа перед удалением столбца
            $table->dropForeign(['department_id']);
            // Теперь можно безопасно удалить столбец
            $table->dropColumn('department_id');
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
            // Добавляем столбец обратно
            $table->unsignedBigInteger('department_id')->nullable();
            // Восстанавливаем внешний ключ
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }
};
