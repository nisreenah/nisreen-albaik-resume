<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'en_title',
        'ar_title',
        'year',
        'image',
    ];
}
