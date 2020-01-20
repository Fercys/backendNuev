<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
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
            $table->string('agregar_icoterms');            
            $table->unsignedBigInteger('id_pedido')->unsigned();
            $table->foreign('id_pedido')
                ->references('id')
                ->on('encabezados')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_producto')->unsigned();
            $table->foreign('id_producto')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('cantidad_kg')->nullable();
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
        Schema::dropIfExists('detalles');
    }
}
