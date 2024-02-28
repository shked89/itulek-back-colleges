<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Speciality;
class Qualification extends Model
{
    // Указание имени таблицы
    protected $table = 'college.qualifications';

    // Включение временных меток (created_at и updated_at)
    public $timestamps = false;

    // Защищённые поля для массового назначения
    protected $fillable = [
        'title',
        'qualification_code',
        'speciality_id',
    ];

    /**
     * Связь с моделью Speciality.
     */
    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }
    
    public function collegeQualifications()
    {
        return $this->hasMany(CollegeQualification::class, 'qualification_id');
    }
    

    // Здесь можно добавить дополнительные связи, аксессоры, мутаторы и другие методы Eloquent, если они вам нужны
}

