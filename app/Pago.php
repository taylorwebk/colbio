<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';//plural aveces se escribe mal
    //protected $primaryKey = 'id';
    protected $fillable = ['idafiliado','modalidad','fecha_modalidad','codigo_verificacion','fecha_pago','num_meses','fecha_vencimiento','monto'];
}
