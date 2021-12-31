<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'schedules_date', 
        'patient_id', 
        'user_id'
    ];

    public function patients(){
        return $this->belongsTo(Patient::class);
    }

    public function schedule_dates(){
        return $this->belongsToMany(Available::class, 'schedules_date', foreignPivotKey: 'schedule_id', relatedPivotKey: 'available_id');
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
