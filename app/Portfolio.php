<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'en_name',
        'ar_name',
        'image',
        'en_client',
        'ar_client',
        'completion',
        'en_role',
        'ar_role',
        'category_id',
        'en_details',
        'ar_details'
    ];

    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function gallery(){
        return $this->hasMany('App\Gallery');
    }

    public function delete()
    {
        if(file_exists('file_path')){
            @unlink('file_path');
        }
        parent::delete();
    }
}
