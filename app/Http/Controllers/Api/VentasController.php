<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\Producto;

class VentasController extends Controller
{
  
    public function misPedidos(Request $request){
      
        $user = $request->user();


        $ventas = Venta::where('id_user', $user->id)
                        ->select(['id', 'id_producto', 'cantidad', 'total', 'created_at'])
                        ->with([
                            'producto' => function($query){
                                $query->select(['id', 'nombre']);
                            }
                        ])
                        ->orderBy('created_at', 'desc')
                        ->get();
        

        return response()->json($ventas,200);
    }

  
    public function registrar(Request $request){

        $request->validate([
            'id_producto' => 'required|integer',
            'cantidad' => 'required|integer',
            'direccion' => 'required|string'
        ]);

        $user = $request->user();

        $producto = Producto::find($request->id_producto);

        if(!$producto){
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $total = $producto->precio * $request->cantidad;

        $venta = Venta::create([
            'id_producto' => $request->id_producto,
            'id_user' => $user->id,
            'cantidad' => $request->cantidad,
            'total' => $total,
            'direccion' => $request->direccion
        ]);
     

        return response()->json(['message' => 'Venta registrada exitosamente', 'venta' => $venta],200);

    }


   
}
