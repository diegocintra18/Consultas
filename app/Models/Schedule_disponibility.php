<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule_disponibility extends Model
{
    use HasFactory;

    protected $table = 'schedule_disponibility';

    protected $fillable = [
        'schedule_sunday',
        'schedule_monday',
        'schedule_tuesday',
        'schedule_wednesday',
        'schedule_thursday',
        'schedule_friday',
        'schedule_saturday',
        'schedule_settings_id',
    ];

    public function schedule_settings() {
        return $this->belongsTo(Schedule_settings::class);
    }
}
