<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Birthday extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birthday',
    ];

    protected $dates = [
        'birthday', 'created_at', 'updated_at'
    ];


}
