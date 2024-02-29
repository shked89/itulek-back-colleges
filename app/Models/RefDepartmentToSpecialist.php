<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDepartmentToSpecialist extends Model
{
    /**
     * Ассоциированная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'college.ref_department_to_discipline';

    /**
     * Поля, доступные для массового присвоения.
     *
     * @var array
     */
    protected $fillable = ['department_id', 'discipline_id'];

    /**
     * Отключение меток времени, если они не используются.
     */
    public $timestamps = false;

    /**
     * Отношение к департаменту.
     */
    public function department()
    {
        // Предполагается, что у вас уже есть модель Department, связанная с таблицей departments
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Отношение к дисциплине.
     */
    public function discipline()
    {
        // Предполагается, что у вас уже есть модель Discipline, связанная с таблицей disciplines
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }
}