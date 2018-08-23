<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;

use App\Afiliado;
use App\Pago;
use App\Titulo;

class TitulosController extends Controller
{
    public function index(Request $request)
    {

        $titulos = DB::table('titulos as t')
        ->where('t.idafiliado', '=', $request->id)
        ->select('t.*')
        ->get();

        $afiliado = DB::table('afiliados as a')
        ->where('a.id','=', $request->id)
        ->select('id','apellido_paterno','apellido_materno','nombres','ci','modalidad','fecha_modalidad')
        ->get();

        return [
            'afiliado' => $afiliado,
            'titulos'=>$titulos
        ];

    }
    public function store(Request $request)
    {
        $titulo = new Titulo();
        $titulo->idafiliado=$request->afiliado_id;
        $titulo->universidad=$request->universidad;
        $titulo->nombre_titulo=$request->nombre_titulo;
        $titulo->fecha_titulo=$request->fecha_titulo;
        $titulo->numero_titulo=$request->numero_titulo;
        $titulo->ciudad=$request->ciudad;
        $titulo->pais=$request->pais;
        $titulo->fecha_prov=$request->fecha_prov;
        $titulo->numero_prov=$request->numero_prov;

        $titulo->tipo=$request->tipo;
        $titulo->grado=$request->grado;

        $titulo->url_img=$request->url_img;
        $titulo->save();
    }
    public function update(Request $request){
        if (!$request->ajax()) return redirect('/');
        $titulo = Titulo::findOrFail($request->id);
        //datos personales
        $titulo->universidad=$request->universidad;
        $titulo->nombre_titulo=$request->nombre_titulo;
        $titulo->fecha_titulo=$request->fecha_titulo;
        $titulo->numero_titulo=$request->numero_titulo;
        $titulo->ciudad=$request->ciudad;
        $titulo->pais=$request->pais;
        $titulo->fecha_prov=$request->fecha_prov;
        $titulo->numero_prov=$request->numero_prov;
        $titulo->url_img=$request->url_img;
        $titulo->tipo=$request->tipo;
        $titulo->grado=$request->grado;
        $titulo->save();
    }
    public function destroy(Request $request){
        Titulo::destroy($request->id);
    }
}
