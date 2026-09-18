<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    //
    public function index()
    {
        $respuesta = DB::table('clientes')
            ->select('id as id_clie', 'nombres as nombre_clie', 'cel', 'telefono', 'correo', 'descripcion', 'estado')
            ->get();

        return response()->json([$respuesta]);
    }

    public function store(Request $request)
    {
        $request->validate([
            's_nombre' => 'required|string',
            's_cel' => 'string',
            's_telefono' => 'string',
            's_correo' => 'required|string',
            's_descripcion' => 'required|string',
        ]);

        $p_nombre = $request->s_nombre;
        $p_cel = $request->s_cel;
        $p_telefono = $request->s_telefono;
        $p_correo = $request->s_correo;
        $p_descripcion = $request->s_descripcion;

        $respuesta = DB::select('SELECT * FROM fn_insertar_cliente(?,?,?,?,?)', [$p_nombre, $p_cel, $p_telefono, $p_correo, $p_descripcion]);

        return response()->json([$respuesta]);
    }

    public function changer(Request $request)
    {
        $request->validate([
            's_id' => 'required',
        ]);

        $p_id = $request->s_id;

        $cliente = DB::table('clientes')->where('id', $p_id)->first();
        if (!$cliente) {
            return response()->json([[['mensa' => 'Cliente no encontrado', 'error' => 1]]]);
        }
        $nuevoEstado = $cliente->estado == 1 ? 0 : 1;

        DB::table('clientes')->where('id', $p_id)->update(['estado' => $nuevoEstado]);

        return response()->json([[['mensa' => 'Estado del cliente actualizado correctamente.', 'error' => 0, 'numid' => $p_id]]]);
    }

    public function update(Request $request)
    {
        $request->validate([
            's_id' => 'required',
            's_nombre' => 'required|string',
            's_cel' => 'string',
            's_telefono' => 'string',
            's_correo' => 'required|string',
            's_descripcion' => 'required|string',
        ]);

        DB::table('clientes')->where('id', $request->s_id)->update([
            'nombres' => $request->s_nombre,
            'cel' => $request->s_cel,
            'telefono' => $request->s_telefono,
            'correo' => $request->s_correo,
            'descripcion' => $request->s_descripcion,
        ]);

        return response()->json([[['mensa' => 'Cliente actualizado exitosamente', 'error' => 0, 'numid' => $request->s_id]]]);
    }

}
