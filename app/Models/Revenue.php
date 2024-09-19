<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Revenue extends Model
{
    use HasFactory;

    protected $table = 'revenue';
    protected $fillable = [
        'amount', 'type', 'payment_method', 'date', 'branch_id',
    ];

    public function branch(): BelongsTo    
    {
        return $this->belongsTo(Branch::class);
    }
    
}
