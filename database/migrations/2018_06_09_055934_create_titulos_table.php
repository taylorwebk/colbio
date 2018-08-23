<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titulos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idafiliado')->unsigned();
            $table->foreign('idafiliado')->references('id')->on('afiliados');
            $table->string('universidad',80);
            $table->string('nombre_titulo',80);
            $table->date('fecha_titulo');
            $table->integer('numero_titulo');
            $table->string('ciudad',40);
            $table->string('pais',40);
            $table->date('fecha_prov');
            $table->integer('numero_prov');
            $table->string('url_img',100)->nullable();
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
        Schema::dropIfExists('titulos');
    }
}
