<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // Указание имени таблицы, если оно отличается от стандартного Laravel названия
    protected $table = 'college.departments';

    // Отключение временных меток, если они не используются
    public $timestamps = false;

    // Защищённые поля, которые можно массово назначать
    protected $fillable = [
        'caption',
    ];

    // Здесь можно добавить дополнительные связи, аксессоры или мутаторы, если они нужны
}