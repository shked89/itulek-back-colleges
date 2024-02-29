<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\College;
use App\Models\DisciplineType;
use App\Models\Department;
class Discipline extends Model
{
    // Указание имени таблицы
    protected $table = 'college.disciplines';

    // Отключение временных меток, если они не используются
    public $timestamps = false;

    // Защищённые поля, которые можно массово назначать
    protected $fillable = [
        'caption',
        'discipline_type_id',
        'department_id',
        'college_id',
    ];

    /**
     * Связь с моделью Department.
     */
    public function departments()
    {
        return $this->belongsToMany(
            Department::class, 
            'college.ref_department_to_discipline', // Имя таблицы связи
            'discipline_id', // Внешний ключ для текущей модели (Discipline)
            'department_id'  // Внешний ключ для модели Department
        );
    }

    public function discipline_type()
    {
        return $this->belongsTo(DisciplineType::class, 'discipline_type_id');
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