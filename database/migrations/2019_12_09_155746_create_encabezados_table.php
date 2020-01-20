<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncabezadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encabezados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('autorizado')->default(false);
            $table->integer('nro_sap')->default(0);
            $table->integer('op')->default(0);
            $table->integer('proforma')->default(0);
            $table->integer('reserva')->default(0);
            $table->integer('cliente_id');
            $table->date('f_entrega_deseada')->nullable();
            $table->date('f_creacion')->nullable();
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
        Schema::dropIfExists('encabezados');
    }
}
