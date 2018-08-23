<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensualidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensualidad', function (Blueprint $table) {
            $table->increments('id');
           
            $table->integer('idafiliado')->unsigned();
            $table->foreign('idafiliado')->references('id')->on('afiliados');

            $table->integer('idpago')->unsigned();
            $table->foreign('idpago')->references('id')->on('pagos');
            
            $table->integer('monto_mes');
            $table->date('fecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensualidad');
    }
}
