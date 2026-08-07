<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\FrutasController;
use App\Http\Controllers\ProvedorController;
use App\Http\Controllers\UserController;
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
Route::post('auth/cambiar-contra/user',[UserController::class,'cambiarEstadoUsuario']);
Route::post('auth/roler-user/asignar',[UserController::class,'asignacionRol']);

//Provedor
Route::get('provedor/index',[ProvedorController::class,'index']);
Route::post('provedor/store',[ProvedorController::class,'store']);
Route::post('provedor/cambiar-estado',[ProvedorController::class,'changer']);

//COMPRA
Route::post('compra/store',[CompraController::class,'store']);
Route::post('compra/editar-estado',[CompraController::class,'editarEstado']);
Route::get('compra/index',[CompraController::class,'listarCompra']);

//fruta
Route::post('fruta/listar',[FrutasController::class,'index']);




