<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'p_email' => 'required|email',
            'p_password' => 'required|string',
        ]);

        $email = $request->p_email;
        $password = $request->p_password;

        $usuarios = DB::select('SELECT * FROM sp_login(?)', [$email]);

        if (empty($usuarios)) {
            return response()->json(['mensaje' => 'Credenciales inválidas','error' => '100'], 401);
        }

        $usuario = $usuarios[0];

        if (Hash::check($password, $usuario->password_hash)) {

            $userModel = new User((array) $usuario);

            $userModel->id = $usuario->id;

            // Genero el Token 
            $token = $userModel->createToken('auth_token')->plainTextToken;

            unset($usuario->password_hash);


            return response()->json([
                'token' => $token,
                'cliente' => $usuario,
                'error' => '0'
            ], 200);

        } else {
            return response()->json(['mensaje' => 'Credenciales inválidas','error' => '100'], 401);
        }
    }


}
