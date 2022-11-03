<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Publication extends Model
{
    use HasFactory, softDeletes, Sortable;


    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_expiracao', 'data_lancamento', 'data_publicacao'];

    public $sortable = ['id', 'titulo', 'tipo', 'user_id', 'data_expiracao', 'status', 'publicado'];

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

//    relações com History
    public function history()
    {
        return $this->hasMany('App\Models\History')->orderBy('created_at', 'desc');
    }

//    //publications by user
//    public function scopeByUser($query, $user_id)
//    {
//        $query->where('user_id', $user_id);
//    }

}
