<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovementProduct;
use Illuminate\Http\Request;
// OK
class MovementProductController extends Controller
{
    /**
     * Display a listing of the movement-product associations.
     */
    public function index()
    {
        $associations = MovementProduct::with(['movement', 'product'])->get();
        return response()->json($associations);
    }


}
