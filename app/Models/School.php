<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
    public function revenues(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }
    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
}
