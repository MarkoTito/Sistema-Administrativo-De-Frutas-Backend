<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrutasController extends Controller
{
    //

    public function index()
    {
        // lista de provedores
        $respuesta = DB::select('SELECT * FROM listar_fruta()');

        return response()->json([$respuesta]);
    }
}
