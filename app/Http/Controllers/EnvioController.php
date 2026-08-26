<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnvioController extends Controller
{
    //
    public function store(Request $request){
        return response()->json(['mensaje'=>$request->costo_estiba]); 
            
    }
}
