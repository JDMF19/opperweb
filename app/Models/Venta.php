<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model 
{

    protected $table = 'ventas';
    protected $fillable = ['id_producto', 'id_user', 'cantidad', 'total', 'direccion'];


    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

}