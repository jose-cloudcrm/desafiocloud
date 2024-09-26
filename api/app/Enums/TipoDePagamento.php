<?php

namespace App\Enums;

enum TipoDePagamento: int
{
    case DEBITO = "debito";
    case CREDITO = "credito";

    public function enumName(): string
    {
        return match($this) {
            TipoDePagamento::DEBITO => 'Debito',
            TipoDePagamento::CREDITO => 'Cartão de Crédito',
        };
    }
}
