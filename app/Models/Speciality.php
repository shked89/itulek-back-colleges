<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    // Указание имени таблицы
    protected $table = 'college.specialities';

    // Включение временных меток (created_at и updated_at)
    public $timestamps = false;

    // Защищённые поля для массового назначения
    protected $fillable = [
        'title',
        'speciality_code',
    ];

    public function qualifications()
    {
        return $this->hasMany(Qualification::class, 'speciality_id');
    }


    // Здесь можно добавить связи, аксессоры, мутаторы и другие методы Eloquent, если они вам нужны
}