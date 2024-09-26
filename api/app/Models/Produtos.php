<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantidade',
        'valor',
    ];

    public function movements()
    {
        return $this->belongsToMany(Movements::class, 'movement_product');
    }
}
