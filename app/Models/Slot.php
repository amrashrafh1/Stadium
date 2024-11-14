<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slot extends Model
{

    protected $fillable = [
        'from',
        'to',
        'schedule_id'
    ];
    // active scope
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function schedule(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

}
