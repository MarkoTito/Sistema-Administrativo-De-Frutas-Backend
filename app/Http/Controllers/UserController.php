<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function login2(Request $request)
    {
        $request->validate([
            'p_email' => 'required|email',
            'p_password' => 'required|string',
        ]);

        $email = $request->p_email;
        $password = $request->p_password;

        $usuarios = DB::select('SELECT * FROM sp_login(?)', [$email]);

        if (empty($usuarios)) {
            return response()->json(['mensaje' => 'Credenciales inválidas'], 401);
        }

        $usuario = $usuarios[0];

        if (Hash::check($password, $usuario->password_hash)) {

            // Genero elToken 
            $userModel = new User((array) $usuario);
            $token = $userModel->createToken('auth_token')->plainTextToken;

            // limpio datos 
            unset($usuario->password_hash);
            
            return response()->json([
                'token' => $token,
                'cliente' => $usuario
            ], 200);
        } else {
            return response()->json(['mensaje' => 'Credenciales inválidas'], 401);
        }
    }



}
