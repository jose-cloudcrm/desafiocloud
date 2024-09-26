<?php

use App\Enums\TipoDePagamento;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

