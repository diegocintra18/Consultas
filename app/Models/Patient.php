<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'patient_firstname',
        'patient_lastname',
        'patient_cpf',
        'patient_phone',
        'patient_email',
        'patient_gender',
        'patient_birth_date',
    ];

    public function addresses(){
        return $this->belongsToMany(Address::class);
    }

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
