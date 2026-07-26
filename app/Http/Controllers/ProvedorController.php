<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvedorController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            's_nombre' => 'required|string',
            's_cel' => 'required|string',
            's_telefono' => 'required|string',
            's_correo' => 'required|string',
            's_descripcion' => 'required|string',
        ]);

        $p_nombre = $request->s_nombre;
        $p_cel = $request->s_cel;
        $p_telefono = $request->s_telefono;
        $p_correo = $request->s_correo;
        $p_descripcion = $request->s_descripcion;

        $respuesta = DB::select('SELECT * FROM fn_insertar_proveedor(?,?,?,?,?)', [$p_nombre, $p_cel, $p_telefono, $p_correo, $p_descripcion]);

        return response()->json([$respuesta]);

        //al del front, te retorno un mensaje y un error si el valor del error es 0 esta bien, caso contrario algo fallo


    }
}
