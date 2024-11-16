<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    protected $table = 'pitches';
    protected $guarded = ['id'];

    public function stadium(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Stadium::class);
    }

    public function schedules() : \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Schedule::class, 'scheduleable');
    }



}
