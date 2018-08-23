<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulo extends Model
{
    protected $table = 'titulos';//plural aveces se escribe mal
    //protected $primaryKey = 'id';
    protected $fillable = ['idafiliado ','universidad ','nombre_titulo ','fecha_titulo ','numero_titulo ','ciudad ','pais ','fecha_prov ','numero_prov ','tipo','grado','url_img'];
}
