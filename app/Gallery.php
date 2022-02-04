<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'image',
        'portfolio_id'
    ];

    public function delete()
    {
        if(file_exists('file_path')){
            @unlink('file_path');
        }
        parent::delete();
    }
}
