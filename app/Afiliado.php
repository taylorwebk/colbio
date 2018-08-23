<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $table = 'afiliados';//plural aveces se escribe mal
    //protected $primaryKey = 'id';


    protected $fillable = ['apellido_paterno ','apellido_materno ','nombres ','fecha_nac ','lugar_nac ','ci ','departamento ','nacionalidad ','estado_civil ','telefono ','celular ','email ','fecha_min_salud ','matricula ','lugar_trabajo ','direccion_trabajo ','modalidad','fecha_modalidad','codigounico ','condicion ','estado'];
    
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
