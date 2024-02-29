<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDepartmentToDiscipline extends Model
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
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Отношение к дисциплине.
     */
    public function discipline()
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }
}
