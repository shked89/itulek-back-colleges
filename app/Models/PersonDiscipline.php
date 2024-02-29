<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonDiscipline extends Model
{
    protected $table = 'college.ref_person_disciplines';

    public $timestamps = false;

    protected $fillable = [
        'caption',
        'discipline_id',
        'person_id',
    ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }

    // Если есть модель для Person, можно добавить связь с ней
    // public function person()
    // {
    //     return $this->belongsTo(Person::class, 'person_id');
    // }
}