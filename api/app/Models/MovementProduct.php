<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'movement_id',
        'product_id',
        'valor',
        'quantidade_pd',
    ];

    public function movement()
    {
        return $this->belongsTo(Movements::class, 'movement_id');
    }

    public function product()
    {
        return $this->belongsTo(Produtos::class, 'product_id');
    }
}
