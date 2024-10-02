<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use Illuminate\Http\Request;
use Exception;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $produtos = Produtos::orderBy('id', 'DESC')->get();
            return response()->json($produtos, 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao buscar produtos.'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


            $request->validate([
                'name' => 'required',
                'quantidade' => 'required|integer',
                'valor_unitario' => 'required|numeric'
            ]);


            $produto = Produtos::create([
                'name' => $request->name,
                'quantidade' => $request->quantidade,
                'valor_unitario' => $request->valor_unitario,
                'valor_total' => $request->quantidade * $request->valor_unitario
            ]);

            return response()->json($produto, 201);

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $produto = Produtos::find($id);

            if (!$produto) {
                return response()->json(['status' => false, 'message' => 'Produto não encontrado.'], 404);
            }

            return response()->json($produto, 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao buscar produto.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $produto = Produtos::find($id);

            if (!$produto) {
                return response()->json(['status' => false, 'message' => 'Produto não encontrado.'], 404);
            }

            $request->validate([
                'name' => 'required',
                'quantidade' => 'required|integer',
                'valor_unitario' => 'required|numeric'
            ]);

            $produto->update([
                'name' => $request->name,
                'quantidade' => $request->quantidade,
                'valor_unitario' => $request->valor_unitario,
                'valor_total' => $request->quantidade * $request->valor_unitario
            ]);

            return response()->json($produto, 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao atualizar produto.'], 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $produto = Produtos::find($id);

            if (!$produto) {
                return response()->json(['status' => false, 'message' => 'Produto não encontrado.'], 404);
            }

            $produto->delete();
            return response()->json(['status' => true, 'message' => 'Produto deletado com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro ao deletar produto.'], 404);
        }
    }
}
