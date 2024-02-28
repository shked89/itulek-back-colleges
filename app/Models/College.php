<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    
    protected $table = 'college.colleges';
    
    public $timestamps = false;

    protected $fillable = ['title'];
    
}