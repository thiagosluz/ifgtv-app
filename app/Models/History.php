<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at'];

//    relações com User
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
