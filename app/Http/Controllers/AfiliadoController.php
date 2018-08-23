<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Afiliado;
use App\Pago;
use App\User;


class AfiliadoController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            //$afiliados = Afiliado::orderBy('id', 'desc')->paginate(5);
            $afiliados = User::join('afiliados','users.id','=','afiliados.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('afiliados.*','users.usuario','users.password',
            'users.idrol','roles.nombre as rol')
            ->orderBy('afiliados.id', 'desc')->paginate(3);
        }
        else{
            //$afiliados = Afiliado::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(5);
            $afiliados = User::join('afiliados','users.id','=','afiliados.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('afiliados.*','users.usuario','users.password',
            'users.idrol','roles.nombre as rol')
            ->where('afiliados.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('afiliados.id', 'desc')->paginate(3);
        }
        return [
            'pagination' => [
                'total'        => $afiliados->total(),
                'current_page' => $afiliados->currentPage(),
                'per_page'     => $afiliados->perPage(),
                'last_page'    => $afiliados->lastPage(),
                'from'         => $afiliados->firstItem(),
                'to'           => $afiliados->lastItem(),
            ],
            'afiliados' => $afiliados
        ];

    }

    public function afiliadoAporte(Request $request)
    {
        //listamos los afiliados activos
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;        
        if ($buscar==''){
            $afiliados =  Afiliado::select('id','apellido_paterno','apellido_materno','nombres','ci','codigounico','modalidad','fecha_modalidad','condicion')
            ->orderBy('id', 'desc')
            ->paginate(5);
        }
        else{
            $afiliados =  Afiliado::where($criterio, 'like', '%'. $buscar . '%')
            ->select('id','apellido_paterno','apellido_materno','nombres','ci','codigounico','modalidad','fecha_modalidad','condicion')
            ->orderBy('id', 'desc')
            ->paginate(5);
        }
        return [
            'pagination' => [
                'total'        => $afiliados->total(),
                'current_page' => $afiliados->currentPage(),
                'per_page'     => $afiliados->perPage(),
                'last_page'    => $afiliados->lastPage(),
                'from'         => $afiliados->firstItem(),
                'to'           => $afiliados->lastItem(),
            ],
            'afiliados' => $afiliados
        ];
    }

    public function ultimoPago(Request $request)
    {
        $pago = Pago::where('idafiliado','=', $request->id)
        ->select('idafiliado','fecha_vencimiento')->orderBy('fecha_vencimiento', 'desc')->first();
        return ['pago' => $pago];
    }
    

    
    public function perfil(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $titulos = DB::table('titulos as t')
        ->where('t.idafiliado', '=', $request->id)
        ->get();

        $afiliado = DB::table('afiliados as a')
        ->where('a.id','=', $request->id)
        ->get();

        return [
            'afiliado' => $afiliado,
            'titulos'=>$titulos
        ];

    }
    
    public function perfilPdf(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $titulos = DB::table('titulos as t')
        ->where('t.idafiliado', '=', $request->id)
        ->get();
        
        $afiliado = Afiliado::find($request->id);

        $pdf = \PDF::loadView('pdf.perfil',['afiliado'=>$afiliado,'titulos'=>$titulos]);
        return $pdf->download('perfil.pdf');
    }

    public function reporteAfiliadosGestion(Request $request){
        $afiliados = Afiliado::whereYear('fecha_modalidad', $request->gestion)
        ->where('condicion','=',1)
        ->get();

        $cantNuevos = Afiliado::whereYear('fecha_modalidad', $request->gestion)
        ->where('condicion','=',1)
        ->where('Modalidad','like','NUEVO')
        ->count();

        $cantTraspaso = Afiliado::whereYear('fecha_modalidad', $request->gestion)
        ->where('condicion','=',1)
        ->where('Modalidad','like','TRASPASO')
        ->count();
       
        $pdf = \PDF::loadView('pdf.gestion',['gestion'=>$request->gestion,'afiliados'=>$afiliados,'cantNuevos'=>$cantNuevos,'cantTraspaso'=>$cantTraspaso]);
        return $pdf->download('Afiliados_Gestion.pdf');
    }

    public function deudores(Request $request){
        
        $ultimoPago = DB::table('pagos')
                   ->select('idafiliado', DB::raw('MAX(fecha_vencimiento) as fv'))
                   ->groupBy('idafiliado');

        $afiliados = DB::table('afiliados')
                ->joinSub($ultimoPago, 'ultimo_pago', function($join) {
                    $join->on('afiliados.id', '=', 'ultimo_pago.idafiliado');
                })->whereDate('ultimo_pago.fv','<' , $request->fecha )
                ->get();

        //return $afiliados;

        $pdf = \PDF::loadView('pdf.deudores',['afiliados'=>$afiliados,'fecha'=>$request->fecha ]);
        return $pdf->download('Deudores.pdf');
    }

    public function nodeudores(Request $request){        
        $ultimoPago = DB::table('pagos')
                   ->select('idafiliado', DB::raw('MAX(fecha_vencimiento) as fv'))
                   ->groupBy('idafiliado');

        $afiliados = DB::table('afiliados')
                ->joinSub($ultimoPago, 'ultimo_pago', function($join) {
                    $join->on('afiliados.id', '=', 'ultimo_pago.idafiliado');
                })->whereDate('ultimo_pago.fv','>=' ,'2018-07-24')
                ->get();
        $pdf = \PDF::loadView('pdf.nodeudores',['afiliados'=>$afiliados,'fecha'=>$request->fecha ]);
        return $pdf->download('Afiliados_no_deuda.pdf');
    }

 
    public function store(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            
            $afiliado = new Afiliado();
            $afiliado->apellido_paterno=$request->apellido_paterno;
            $afiliado->apellido_materno=$request->apellido_materno;
            $afiliado->nombres=$request->nombres;
            $afiliado->fecha_nac=$request->fecha_nac;
            $afiliado->lugar_nac=$request->lugar_nac;
            $afiliado->ci=$request->ci;
            $afiliado->departamento=$request->departamento;
            $afiliado->nacionalidad=$request->nacionalidad;
            $afiliado->estado_civil=$request->estado_civil;
            $afiliado->telefono=$request->telefono;
            $afiliado->celular=$request->celular;
            $afiliado->email=$request->email;

            $afiliado->fecha_min_salud=$request->fecha_min_salud;
            $afiliado->matricula=$request->matricula;
            $afiliado->lugar_trabajo=$request->lugar_trabajo;
            $afiliado->direccion_trabajo=$request->direccion_trabajo;

            $afiliado->modalidad=$request->modalidad;
            $afiliado->fecha_modalidad=$request->fecha_modalidad;
            
            $afiliado->codigounico=$request->codigounico;
            $afiliado->condicion=3; //3 por que no tiene Titulo
            $afiliado->estado="Activo";
            $afiliado->save();

            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;          
            $user->id = $afiliado->id;
            $user->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function update(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);

            $afiliado = Afiliado::findOrFail($request->id);
            //datos personales
            $afiliado->apellido_paterno=$request->apellido_paterno;
            $afiliado->apellido_materno=$request->apellido_materno;
            $afiliado->nombres=$request->nombres;
            $afiliado->fecha_nac=$request->fecha_nac;
            $afiliado->lugar_nac=$request->lugar_nac;
            $afiliado->ci=$request->ci;
            $afiliado->departamento=$request->departamento;
            $afiliado->nacionalidad=$request->nacionalidad;
            $afiliado->estado_civil=$request->estado_civil;
            $afiliado->telefono=$request->telefono;
            $afiliado->celular=$request->celular;
            $afiliado->email=$request->email;

            //datos academicos
            $afiliado->fecha_min_salud=$request->fecha_min_salud;
            $afiliado->matricula=$request->matricula;
            $afiliado->lugar_trabajo=$request->lugar_trabajo;
            $afiliado->direccion_trabajo=$request->direccion_trabajo;
            $afiliado->modalidad=$request->modalidad;
            $afiliado->fecha_modalidad=$request->fecha_modalidad;
            $afiliado->codigounico=$request->codigounico;
            $afiliado->save();
            
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }



    }

    public function deshabilitar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $afiliado = Afiliado::findOrFail($request->id);
        $afiliado->estado = $request->motivo;
        $afiliado->fecha_modalidad = $request->fecha_motivo;
        $afiliado->condicion = '0';
        $afiliado->save();
    }

    public function habilitar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $afiliado = Afiliado::findOrFail($request->id);
        $afiliado->estado = 'Activo';
        $afiliado->modalidad = $request->motivo;
        $afiliado->fecha_modalidad = $request->fecha_motivo;
        $afiliado->condicion = '1';
        $afiliado->save();
    }
}
