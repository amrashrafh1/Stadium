<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean',
        'date'      => 'date'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class, 'schedule_id');
    }

    public function slots(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Slot::class, 'schedule_id');
    }

    public function scheduleable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }


    public function getAvailableSlots()
    {
        $is_today = false;
        $date     = Carbon::today();

        // check if same day and if request date is today
        if ($this->day === $date->translatedFormat('l') && request()->date && Carbon::parse(request()->date)->isToday()) {
            $is_today = true;
        }

        return $this->slots()->active()
            ->when($is_today, function ($q) {
                $q->whereTime('from', '>=', now()->format('H:i:s'));
            })->get();
    }


}
