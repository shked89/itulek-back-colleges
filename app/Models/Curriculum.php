<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    // Указание имени связанной таблицы
    protected $table = 'college.curriculums';

    // Отключение автоматического управления столбцами timestamps (created_at и updated_at)
    public $timestamps = false;

    // Определение защищенных атрибутов для массового назначения
    protected $fillable = [
        'title',
        'year',
        'speciality_id',
        'study_group_id',
        'college_id'
    ];

    /**
     * Определение связи с моделью Speciality.
     */
    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }
}
