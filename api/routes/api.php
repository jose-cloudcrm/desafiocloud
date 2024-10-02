<?php

use App\Enums\TipoDePagamento;
use App\Http\Controllers\Api\MovementsController;
use App\Http\Controllers\Api\MovementProductController;
use App\Http\Controllers\Api\ProdutosController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/users', [UserController::class, 'index']); //http://127.0.0.1:8000/api/users
Route::get('/users/checkemail', [UserController::class, 'check']);//http://127.0.0.1:8000/api/users/check-email
Route::get('/users/{user}', [UserController::class, 'show']); //http://127.0.0.1:8000/api/users/1
Route::post('/users', [UserController::class,'store']); //http://127.0.0.1:8000/api/users
Route::put('/users/{user}', [UserController::class,'update']); //http://127.0.0.1:8000/api/users/1
Route::delete('/users/{user}', [UserController::class,'destroy']); //http://127.0.0.1:8000/api/users/1

Route::get('/teste',function(){
    dd(array_column(TipoDePagamento::cases(), 'name'));
});
Route::apiResource('/produtos',ProdutosController::class);


Route::apiResource('movements',MovementsController::class);
// Route::get('/movements', [MovementsController::class, 'index']); //http://127.0.0.1:8000/api/movements
Route::get('/movement/debits', [MovementsController::class, 'somaDebitos']);//http://127.0.0.1:8000/api/movement/debits
Route::get('/movement/credit', [MovementsController::class, 'somaCredito']);//http://127.0.0.1:8000/api/movement/credit
Route::get('/movement/totalmetodos', [MovementsController::class, 'somaDosMetodos']);//http://127.0.0.1:8000/api/movement/totalmetodos
// Route::get('/movements/{produto}', [MovementsController::class, 'show']); //http://127.0.0.1:8000/api/movements/1
// Route::post('/movements', [MovementsController::class,'store']); //http://127.0.0.1:8000/api/movements
// Route::put('/movements/{produto}', [MovementsController::class,'update']); //http://127.0.0.1:8000/api/movements/1
// Route::delete('/movements/{id}', [MovementsController::class,'destroy']); //http://127.0.0.1:8000/api/movements/1
Route::get('/movements/search', [MovementsController::class, 'pesquisapagamento']); //http://127.0.0.1:8000/api/movements/search
Route::get('/movement/export-csv', [MovementsController::class, 'exportMovementsCsv']);//http://127.0.0.1:8000/api/movement/export-csv
Route::post('/movementproducts', [MovementProductController::class, 'store']);


