<?php

namespace App\Http\Controllers\Api;

use App\Enums\TipoDePagamento;
use App\Http\Controllers\Controller;
use App\Models\Movements;
use App\Models\Produtos;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use League\Csv\Writer;

class MovementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $movimentacoes = Movements::orderBy('id', 'DESC')->with(['user', 'produtos'])->paginate(5);
            return response()->json($movimentacoes, 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Movimentações não encontradas.'], 404);
        }
    }

    /**
     * Search movements by payment type.
     */
    public function pesquisapagamento(Request $request)
    {
        try {
            $tipoPagamento = $request->input('tipo_pagamento');

            if (!$tipoPagamento) {
                return response()->json([
                    'status' => false,
                    'message' => 'O tipo de pagamento deve ser informado.'
                ], 400);
            }

            $movimentacoes = Movements::where('tipoDePagamento', $tipoPagamento)
                ->with(['user', 'produtos'])
                ->orderBy('id', 'DESC')
                ->paginate(7);

            if ($movimentacoes->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'Nenhuma movimentação encontrada.'], 404);
            }

            return response()->json($movimentacoes, 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao buscar movimentações.'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'produtos_id' => 'required|array',
                'usuario_id' => 'required|exists:users,id',
                'tipoDePagamento' => ['required', Rule::in(array_column(TipoDePagamento::cases(), 'value'))],
                'bloqueado' => 'boolean'
            ]);

            $produtos = Produtos::whereIn('id', $request->produtos_id)->get();
            if ($produtos->isEmpty() || $produtos->contains(function($produto) {
                return $produto->valor_total === null;
            })) {
                return response()->json([
                    'status' => false,
                    'message' => 'Um ou mais produtos não têm valor definido.'
                ], 400);
            }

            $valorTotal = $produtos->sum('valor_total');
            dd($valorTotal);
            $movimentacao = Movements::create([
                'usuario_id' => $request->usuario_id,
                'tipoDePagamento' => $request->tipoDePagamento,
                'bloqueado' => $request->bloqueado,
                'valor_total' => $valorTotal,
            ]);

            $movimentacao->produtos()->attach($request->produtos_id);

            return response()->json($movimentacao, 201);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao criar movimentação.'], 404);
        }
    }

    public function somaDebitos()
    {
        try {
            $total = Movements::where('tipoDePagamento', 'debito')->sum('valor_total');
            return response()->json(['total_debits' => $total], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao calcular total de débitos.'], 404);
        }
    }

    public function somaCredito()
    {
        try {
            $total = Movements::where('tipoDePagamento', 'credito')->sum('valor_total');
            return response()->json(['total_credits' => $total], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao calcular total de créditos.'], 404);
        }
    }

    public function somaDosMetodos()
    {
        try {
            $total = Movements::sum('valor_total');
            return response()->json(['total_movements' => $total], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao calcular total de movimentos.'], 404);
        }
    }

    public function exportMovementsCsv(Request $request)
    {
        try {
            $query = Movements::query();

            if ($request->filter === 'last_30_days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            } elseif ($request->has('month') && $request->has('year')) {
                $query->whereYear('created_at', $request->year)->whereMonth('created_at', $request->month);
            }

            $movements = $query->get(['id', 'usuario_id', 'tipoDePagamento', 'valor_total', 'created_at']);

            if ($movements->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'Nenhuma movimentação encontrada para exportar.'], 404);
            }

            $csv = Writer::createFromString('');
            $csv->insertOne(['ID', 'Usuário ID', 'Tipo de Pagamento', 'Valor Total', 'Data de Criação']);

            foreach ($movements as $movement) {
                $csv->insertOne([
                    $movement->id,
                    $movement->usuario_id,
                    $movement->tipoDePagamento,
                    $movement->valor_total,
                    $movement->created_at,
                ]);
            }
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="movements.csv"',
            ];

            return Response::stream(function () use ($csv) {
                echo $csv;
            }, 200, $headers);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao exportar movimentações.'], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $tipoDePagamento = $request->input('tipoDePagamento');

            if (!$tipoDePagamento) {
                return response()->json([
                    'status' => false,
                    'message' => 'O tipo de pagamento deve ser informado.'
                ], 400);
            }

            $movimentacoes = Movements::where('tipoDePagamento', $tipoDePagamento)
                ->with(['user', 'produtos'])
                ->orderBy('id', 'DESC')
                ->get();

            if ($movimentacoes->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'Nenhuma movimentação encontrada.'], 404);
            }

            return response()->json($movimentacoes, 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao buscar movimentações.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $delete = Movements::find($id);

            if (!$delete) {
                return response()->json(['status' => false, 'message' => 'Movimentação não encontrada.'], 404);
            }

            $delete->delete();
            return response()->json(['status' => true, 'message' => 'Movimentação deletada com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao deletar movimentação.'], 404);
        }
    }
}
