<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table='roles';
    protected $filleable=['nombre','descripcion','condicion'];
    public $timestamps = false;

    //userS por que un Rol puede tener varios usuarios
    public function users()
    {
        return $this->hasMany('App\User');
        
    }
}