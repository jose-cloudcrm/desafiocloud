<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movements extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipoDePagamento',
        'bloqueado',
        'usuario_id',
        'valor_total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function produtos()
    {
        return $this->belongsToMany(Produtos::class, 'movement_product')
            ->withTimestamps();
    }
}

