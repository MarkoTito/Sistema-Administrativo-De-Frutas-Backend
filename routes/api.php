<?php

use App\Http\Controllers\CamaraController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\FrutasController;
use App\Http\Controllers\ProvedorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\cajachicaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//auth
Route::post('auth/login',[UserController::class,'login']);
Route::post('auth/listar-usuarios',[UserController::class,'index']);
Route::post('auth/make/user',[UserController::class,'store']);
Route::post('auth/update/user',[UserController::class,'editarUsuario']);
Route::post('auth/cambiar-estado/user',[UserController::class,'cambiarEstadoUsuario']);
Route::post('auth/cambiar-contra/user',[UserController::class,'cambiarContraUsuario']);
Route::post('auth/roler-user/asignar',[UserController::class,'asignacionRol']);

//Provedor
Route::get('provedor/index',[ProvedorController::class,'index']);
Route::post('provedor/update',[ProvedorController::class,'update']); //nuevo
Route::post('provedor/store',[ProvedorController::class,'store']);
Route::post('provedor/cambiar-estado',[ProvedorController::class,'changer']);

//COMPRA
Route::post('compra/store',[CompraController::class,'store']);
Route::post('compra/update',[CompraController::class,'update']);
Route::post('compra/editar-estado',[CompraController::class,'editarEstado']);
Route::post('compra/index',[CompraController::class,'listarCompra']);

Route::post('compra/show',[CompraController::class,'show']);
Route::post('compra/one-frutas',[CompraController::class,'onePeido']);
//camara
Route::get('camara/index',[CamaraController::class,'index']);
Route::get('camara/cantidades',[CamaraController::class,'listarCantidades']);
Route::post('camara/one-lote',[CamaraController::class,'listarOneLote']);

//fruta
Route::post('fruta/listar',[FrutasController::class,'index']);

//cliente
Route::get('cliente/listar',[ClienteController::class,'index']);//nuevo
Route::post('cliente/store',[ClienteController::class,'store']);//nuevo
//venta
Route::post('envio/store',[EnvioController::class,'store']);//nuevo

//caja chica
Route::post('cajachica/store',[CajachicaController::class,'store']);//nuevo
Route::post('cajachica/show',[CajachicaController::class,'show']);//nuevo




