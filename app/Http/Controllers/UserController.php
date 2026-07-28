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
            return response()->json(['mensaje' => 'Credenciales inválidas', 'error' => '100'], 401);
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
            return response()->json(['mensaje' => 'Credenciales inválidas', 'error' => '100'], 401);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            's_nombre' => 'required|string',
            's_email' => 'required|string',
            's_password' => 'required|string',
        ]);

        $p_nombre = $request->s_nombre;
        $p_emil = $request->s_email;
        $p_password = Hash::make($request->s_password) ;


        $respuesta = DB::select('SELECT * FROM fn_insertar_usuario(?,?,?)', [$p_nombre, $p_emil, $p_password]);

        return response()->json([$respuesta]);

        //al del front, te retorno un mensaje y un error si el valor del error es 0 esta bien, caso contrario algo fallo
    }
    //para listar usuarios
    public function index(Request $request)
    {
        $request->validate([
            's_nada' => 'required',
        ]);

        $respuesta = DB::select('SELECT * FROM spu_listar_users()');

        return response()->json([$respuesta]);

    }

    public function editarUsuario(Request $request)
    {
        $request->validate([
            's_id' => 'required',
            's_nombre' => 'required|string',
            's_email' => 'required|string',
            's_documento' => 'required|string',
        ]);

        $p_id = $request->s_id;
        $p_nombre = $request->s_nombre;
        $p_emil = $request->s_email;
        $p_identificador = $request->s_documento;


        $respuesta = DB::select('SELECT * FROM spu_users_upd(?,?,?,?)', [$p_id, $p_nombre, $p_emil, $p_identificador]);

        return response()->json([$respuesta]);

    }

    public function cambiarEstadoUsuario(Request $request)
    {
        $request->validate([
            's_id_user' => 'required',
        ]);

        $p_id = $request->s_id_user;

        $respuesta = DB::select('SELECT * FROM spu_cambiar_estado(?)', [ $p_id]);

        return response()->json([$respuesta]);

    }

    

    //aun esta en pruba
    public function asignacionRol(Request $request)
    {
        $request->validate([
            's_id_user' => 'required',
            's_id_rol' => 'required',
            
        ]);

        $p_idusuario = $request->s_id_user;
        $p__idrol = $request->s_id_rol;

        $usuario = User::find(1); 

        $usuario->assignRole('viewer');

        return response()->json([$usuario]);

    }
}
