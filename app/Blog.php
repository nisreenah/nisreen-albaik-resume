<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'en_title',
        'ar_title',
        'posted_by',
        'en_details',
        'ar_details',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'posted_by');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->where('status','accepted');
    }

}
