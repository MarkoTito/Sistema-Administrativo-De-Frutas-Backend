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

    public function listarOneLote(Request $request)
    {

        $request->validate([
            'p_id_lote' => 'required',

        ]);

        $s_id_lote = $request->p_id_lote;

        $respuesta = DB::select('select * from sp_listar_one_camara0(?)',[$s_id_lote]);
        return response()->json([$respuesta]);
    }
}
