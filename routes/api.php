<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProvedorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//auth
Route::post('auth/login',[UserController::class,'login']);
Route::post('auth/make/user',[UserController::class,'store']);
Route::post('auth/roler-user/asignar',[UserController::class,'asignacionRol']);
//Provedor
Route::post('provedor/store',[ProvedorController::class,'store']);

//COMPRA
Route::post('compra/store',[CompraController::class,'store']);



