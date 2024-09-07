<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    // Define the table if it's different from the default
    // protected $table = 'branches';
    
    // Define the primary key if it's different from the default
    // protected $primaryKey = 'id';
    
    // If you are not using timestamps, you can disable them
    // public $timestamps = false;

    // Define fillable fields if needed
    protected $fillable = ['name'];
}
