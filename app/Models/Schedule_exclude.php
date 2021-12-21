<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule_exclude extends Model
{
    use HasFactory;

    protected $table = 'schedule_excludes';

    protected $fillable = [
        'exclude_date',
        'user_id',
    ];

    public function users() {
        return $this->hasMany(User::class);
    }
}
