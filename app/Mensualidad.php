<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensualidad extends Model
{
    protected $table = 'mensualidad';//plural aveces se escribe mal
    //protected $primaryKey = 'id';
    protected $fillable = ['idafiliado ','idpago ','monto_mes ','fecha'];

}
