<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;

use App\Afiliado;
use App\Pago;



class PagosController extends Controller
{
    public function getAportes(Request $request)
    {
        $pagos =  Pago::where('idafiliado','=',$request->id)
        ->select('*')
        ->orderBy('id', 'desc')
        ->get();

        return ['pagos' => $pagos];
    }

    public function store(Request $request)
    {
        $pago = new Pago();
        $pago->idafiliado = $request->idafiliado;
        $pago->modalidad = $request->modalidad;
        $pago->fecha_modalidad = $request->fecha_modalidad;
        $pago->codigo_verficacion = $request->codigo_verficacion;
        $pago->fecha_pago = $request->fecha_pago;
        $pago->num_meses = $request->num_meses;
        $pago->fecha_vencimiento = Carbon::createFromFormat('Y-m-d', $request->fecha_ultimo_pago )->addMonth( $request->num_meses );
        $pago->monto = $request->monto;
        $aux = $pago;
        $pago->save();
    }
    public function recibo(Request $request)
    {
        $afiliado = Afiliado::find($request->id);

        $pagos =  Pago::where('idafiliado','=',$request->id)
        ->select('*')
        ->orderBy('id', 'desc')
        ->take(5)
        ->get();

        $pdf = \PDF::loadView('pdf.recibo',['afiliado'=>$afiliado,'pagos'=>$pagos]);
        return $pdf->download('recibo.pdf');
    }

    public function aportesPdf(Request $request)
    {
        $afiliado = Afiliado::find($request->id);

        $pagos =  Pago::where('idafiliado','=',$request->id)
        ->select('*')
        ->orderBy('id', 'desc')
        ->get();

        $pdf = \PDF::loadView('pdf.recibo',['afiliado'=>$afiliado,'pagos'=>$pagos]);
        return $pdf->download('recibo.pdf');
    }


    public function update(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $pago = Pago::findOrFail($request->id);

        $pago->idafiliado=$request->afiliado_id;
        $pago->num_meses= $request->num_meses;
        $pago->monto_total= $request->monto_total;

        $articulo->save();
    }



}
