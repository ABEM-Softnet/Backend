<?php

namespace App\Models;

use App\Models\Expense;
use App\Models\Revenue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;


    public function school(){
        return $this->belongsTo(School::class);
    }
    public function revenues(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function gradeDivisions(){
        return $this->hasMany(GradeDivision::class);
    }
    public function schoolLeaders(){
        return $this->hasMany(SchoolLeader::class);
    }
}
