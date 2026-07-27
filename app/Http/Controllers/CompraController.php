<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            's_codigo' => 'required',
            's_id_provedor' => 'required',
            's_fecha' => 'required',
            's_observacion' => 'required|string',
            's_total' => 'required',
            //para insertar en la tabla relacion
            's_id_fru' => 'required',
            's_cantidad' => 'required',
            's_subtotal' => 'required',

        ]);

        $p_codigo = $request->s_codigo;
        $p_id_prove = $request->s_id_provedor;
        $p_fecha = $request->s_fecha;
        $p_obs = $request->s_observacion;
        $p_total = $request->s_total;
        $id_venta = 0 ;

        $p_id_fruta = $request->s_id_fru;
        $p_cantidad = $request->s_cantidad;
        $p_precio_uni = $request->s_subtotal;


        $respuesta = DB::select('SELECT * FROM public.spu_compra_ins(?,?,?,?,?)', [$p_codigo, $p_obs, $p_id_prove, $p_total ,$p_fecha]);

        if ($respuesta[0]->error == 0 ) {
            $id_venta = $respuesta[0]->numid;
            //aca deberia ser un forech, pero como solo insertamos una fruta lo dejo asi :v
            $respuesta0 = DB::select('SELECT * FROM public.spu_compra_fruta_ins(?,?,?,?)', [$p_id_fruta, $id_venta, $p_cantidad, $p_precio_uni]);
            return response()->json([$respuesta0]);
        }

        return response()->json([$respuesta]);

        //al del front, te retorno un mensaje y un error si el valor del error es 0 esta bien, caso contrario algo fallo
    }
}
