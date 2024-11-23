<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Support\Carbon;

class ProductosController extends Controller
{
  
    public function lista(Request $request){
      
        $search = $request->input('search');

        $builder = Producto::query();


        if($search){ // permite buscar por nombre o descripción
         
            $builder->where('nombre', 'like', '%'.$search.'%')
                    ->orWhere('descripcion', 'like', '%'.$search.'%');
        }

        $productos = $builder->select(['id', 'nombre', 'imagen', 'precio'])->get();

        
        return response()->json($productos,200);
    }

    public function detalle(Request $request, $id){
      
        $producto = Producto::where('id', $id)->select(['id', 'nombre', 'descripcion', 'imagen', 'precio'])->first();

        if(!$producto){
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto,200);
    }
   
}
