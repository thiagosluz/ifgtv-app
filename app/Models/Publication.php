<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use HasFactory, softDeletes;


    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_expiracao'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopePublicado($query)
    {
        $query->where('publicado', 1);
    }

    //data de expiração
    public function scopeExibir($query)
    {
        $query->WhereDate('data_expiracao', '>=', date('Y-m-d'))
        ->orWhereNull('data_expiracao');
    }

}
