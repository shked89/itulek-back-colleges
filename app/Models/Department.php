<?php

namespace App\Models;

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
        'discipline_id',
        'speciality_id',
        

    ];

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }
    
    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'college.ref_department_to_discipline', 'department_id', 'discipline_id');
    }

}