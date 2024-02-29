<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDepartmentToSpecialist extends Model
{
    use HasFactory;

    protected $table = 'college.ref_speciality_department_college';

    protected $fillable = [
        'speciality_id',
        'department_id',
        'college_id',
    ];

    public $timestamps = false;

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }
}