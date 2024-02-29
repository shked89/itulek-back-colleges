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
        'college_id'       

    ];



    public function college()
    {
        return $this->belongsTo(Speciality::class, 'college_id');
    }
    
    public function specialities()
{
    return $this->belongsToMany(Speciality::class, 'college.ref_speciality_department_college', 'department_id', 'speciality_id');
}


}