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
            $table->string('direccion_entrega')->default("");
            $table->string('ciudad_entrega')->default("");
            $table->string('pais_entrega')->default("");
            $table->string('moneda')->default("");
            $table->string('pais_origen')->default("");
            $table->string('puerto_origen')->default("");
            $table->string('pais_destino')->default("");
            $table->string('puerto_destino')->default("");
            $table->string('condicion_pago')->default("");
            $table->string('agregar_icoterms')->default("");            
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
