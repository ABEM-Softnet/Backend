<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public function school(){
        return $this->belongsTo(School::class);
    }

    public function gradeDivisions(){
        return $this->hasMany(GradeDivision::class);
    }

    public function schoolLeaders(){
        return $this->hasMany(SchoolLeader::class);
    }
}
