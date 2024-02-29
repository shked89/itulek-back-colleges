<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplineType extends Model
{
    protected $table = 'college.discipline_types';
    public $timestamps = false;

    protected $fillable = [
        'title'
    ];
    use HasFactory;
}
