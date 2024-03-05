<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Setor extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'nome',
    ];

    public $sortable = ['id', 'nome'];

    /**
     * Define a relação um para muitos com usuários.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Define a relação um para muitos com publicações.
     */
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

}
