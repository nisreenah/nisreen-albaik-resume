<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'en_major',
        'ar_major',
        'en_university',
        'ar_university',
        'start_date',
        'end_date'
    ];
}
