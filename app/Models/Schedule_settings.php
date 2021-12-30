<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ScheduleDisponibility;

class Schedule_settings extends Model
{
    use HasFactory;

    protected $table = 'schedule_settings';

    protected $fillable = [
        'schedule_duration_limit',
        'schedule_before_break',
        'schedule_after_break',
        'schedule_day_start',
        'schedule_lunch_start',
        'schedule_lunch_end',
        'schedule_day_end',
        'user_id',
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function availables() {
        return $this->hasMany(Available::class);
    }

    public function schedule_disponibility() {
        return $this->hasMany(Schedule_disponibility::class);
    }
}
