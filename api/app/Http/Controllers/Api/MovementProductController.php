<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovementProduct;
use App\Models\Movements;
use App\Models\Produtos;
use Illuminate\Http\Request;

class MovementProductController extends Controller
{
    public function store(Request $request)
    {

        $validated = $request->validate([
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'usuario_id' => 'required|exists:users,id',
            'tipoDePagamento' => 'required|string',
        ]);
        // dd($movimentacao);
        $arrayid = [];
        $valorTotal = 0;
        foreach($validated['produtos'] as $key => $produto){
            $arrayid[$key]= [
                'produto_id' => $produto['produto_id'],
                'quantidade' => $produto['quantidade'],
            ];

            $produtos = Produtos::find($produto['produto_id']);

            if ($produtos->quantidade < $produto['quantidade']) {
                return response()->json([
                    'message' => 'Estoque insuficiente para o produto: ' . $produtos->name
                ], 400);
            }

            $produtos->quantidade -= $produto['quantidade'];
            $produtos->valor_total = $produtos->quantidade * $produtos->valor_unitario;
            $produtos->save();

            $valorTotal += $produto['quantidade'] * $produtos->valor_unitario;
        }

        $movimentacao = Movements::create([
            'usuario_id' => $request->usuario_id,
            'tipoDePagamento' => $request->tipoDePagamento,
            'bloqueado' => $request->bloqueado,
            'valor_total' => $valorTotal,
        ]);

        foreach ($validated['produtos'] as $produto) {
            $movimentacao->produtos()->attach($produto['produto_id'], ['quantidade' => $produto['quantidade']]);
        }

        return response()->json(['message' => 'Movimentação criada com sucesso!'], 201);
    }
}
