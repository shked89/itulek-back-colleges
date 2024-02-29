<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonUnitToDepartment extends Model
{
    protected $table = 'college.ref_person_unit_to_departments';

    public $timestamps = false;

    protected $fillable = [
        'person_unit_id',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}