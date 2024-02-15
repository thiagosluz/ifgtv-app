<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Scout\Searchable;

class Birthday extends Model
{
    use HasFactory, Sortable, Searchable;

    protected $fillable = [
        'name',
        'birthday',
    ];

    protected $dates = [
        'birthday', 'created_at', 'updated_at'
    ];

    public $sortable = [
        'id', 'name', 'birthday'
    ];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name
        ];
    }


}
