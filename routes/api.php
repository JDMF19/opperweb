<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



# Login - Registro

    Route::post('/login', [App\Http\Controllers\Api\Auth\AuthController::class, 'login']);   
    Route::post('/registro-usuario', [App\Http\Controllers\Api\Auth\AuthController::class, 'registro']);   

#---------------------------------------------------------------

# Productos

    Route::get('/lista-productos', [App\Http\Controllers\Api\ProductosController::class, 'lista']);
    Route::get('/detalle-producto/{id}', [App\Http\Controllers\Api\ProductosController::class, 'detalle']);

#---------------------------------------------------------------

# Rutas protegidas

Route::group(['middleware' => ['auth:api']], function() {

    Route::get('/logout', [App\Http\Controllers\Api\Auth\AuthController::class, 'logout']);
    

    # Ventas

        Route::get('/mis-pedidos', [App\Http\Controllers\Api\VentasController::class, 'misPedidos']);   
        Route::post('/registrar-pedido', [App\Http\Controllers\Api\VentasController::class, 'registrar']);   

    #---------------------------------------------------------------


});

