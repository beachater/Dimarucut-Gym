<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'membership_type',
        'mobile_number',
        'email',
        'emergency_contact_name',
        'emergency_contact_number' ,
        'notes'
    ];
}
