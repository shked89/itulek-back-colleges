<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Model;
use App\Models\College;
class Discipline extends Model
{
    // Указание имени таблицы
    protected $table = 'college.disciplines';

    // Отключение временных меток, если они не используются
    public $timestamps = false;

    // Защищённые поля, которые можно массово назначать
    protected $fillable = [
        'caption',
        'discipline_type',
        'department_id',
        'college_id',
    ];

    /**
     * Связь с моделью Department.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Связь с моделью College.
     */
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    // Здесь можно добавить дополнительные связи, аксессоры или мутаторы, если они нужны
}