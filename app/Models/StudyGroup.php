<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyGroup extends Model
{
    use HasFactory;
    
    protected $table = 'college.study_groups';
    
    protected $fillable = ['study_group_title', 'language_iso', 'faculty_id'];
    
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
}