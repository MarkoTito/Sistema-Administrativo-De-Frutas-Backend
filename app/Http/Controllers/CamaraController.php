<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CamaraController extends Controller
{
    //

    public function index()
    {

        $respuesta = DB::select('select * from sp_listar_camara() ');
        return response()->json([$respuesta]);
    }


    public function listarCantidades()
    {

        $respuesta = DB::select('select * from sp_listar_cantidades() ');
        return response()->json([$respuesta]);
    }
}
