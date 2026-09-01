<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnvioController extends Controller
{
    //
    public function store(Request $request){
        return response()->json(['Id_fruta_arra0'=>$request->detalles[0]['id_fruta']]); 
            
    }
}
