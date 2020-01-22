<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proformas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direccion_entrega');
            $table->string('ciudad_entrega');
            $table->string('pais_entrega');
            $table->string('moneda');
            $table->string('pais_origen');
            $table->string('puerto_origen');
            $table->string('pais_destino');
            $table->string('puerto_destino');
            $table->string('condicion_pago');
            $table->string('incoterms');            
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
        Schema::dropIfExists('proformas');
    }
}
