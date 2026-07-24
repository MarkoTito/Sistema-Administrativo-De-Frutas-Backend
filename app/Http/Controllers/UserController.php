<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function login(Request $request)
    {

        $Inusuario = $request->p_email;
        $Incontraseña = $request->p_password;

        $usuaios = DB::select('SELECT * FROM sp_login(?)', [$Inusuario]);
        $usuario = $usuaios[0];

        if (Hash::check($Incontraseña, $usuario->password_hash)) {
            //si paso 
            return response()->json([$usuario]); 
        }else{
            return response()->json(['mensaje'=> 'error al inicar', 'error' => '100']);
        }


    }
}
