<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Available extends Model
{
    use HasFactory;

    protected $table = 'availables';

    protected $fillable = [
        'available_start',
        'available_end',
        'schedule_settings_id',
    ];

    public function schedule_settings() {
        return $this->belongsTo(Schedule_settings::class);
    }
}
