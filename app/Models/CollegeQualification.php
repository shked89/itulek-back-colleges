<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\College;
class CollegeQualification extends Model
{
    use HasFactory;

    protected $table = 'college.ref_college_qualifications';

    public $timestamps = false;

    protected $fillable = ['college_id', 'qualification_id'];


    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, 'qualification_id');
    }
    

}
