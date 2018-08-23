<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afiliados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apellido_paterno',50);
            $table->string('apellido_materno',50);
            $table->string('nombres',60);
            $table->date('fecha_nac');
            $table->string('lugar_nac',50)->nullable();
            $table->string('ci',20);
            $table->string('departamento',40);
            $table->string('nacionalidad',40);
            $table->string('estado_civil',20);
            $table->string('telefono',20)->nullable();
            $table->string('celular',20)->nullable();
            $table->string('email',30)->nullable();
            //datosacademicos

            //tituloenprovicionnacional

            //registroministeriosaluddeportes
            $table->date('fecha_min_salud');
            $table->string('matricula',30);
            //lugar de trabajo
            $table->string('lugar_trabajo',50)->nullable();
            $table->string('direccion_trabajo',60)->nullable();
            //datos de la mensualidad

            $table->string('modalidad',20);//[titulo,traspaso,baja]
            $table->date('fecha_modalidad');

            //codigo de asignacion
            $table->integer('codigounico');
            $table->boolean('condicion')->default(1);
            $table->string('estado',20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('afiliados');
    }
}
