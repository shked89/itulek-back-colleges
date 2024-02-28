<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeAddress extends Model
{
    use HasFactory;
    
    protected $table = 'college.college_addresses';
    
    public $timestamps = false;

    protected $fillable = ['college_id', 'country_name', 'city_id', 'address_name'];
    

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}