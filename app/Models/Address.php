<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'adress_name',
        'address_number',
        'address_zipcode',
        'address_complement',
        'address_city',
        'address_uf',
        'address_district',
    ];

    public function patients(){
        return $this->belongsToMany(Patient::class);
    }
}
