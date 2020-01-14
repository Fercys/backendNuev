<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgrotopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agrotops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Cliente');
            $table->string('Codigo');
            $table->string('FamiliaProducto');
            $table->boolean('Fumigacion');
            $table->boolean('Granel');
            $table->integer('HumedadRelativa');
            $table->integer('IdCliente');
            $table->string('IdClienteSap');
            $table->integer('IdFichaTecnica');
            $table->string('Observacion');
            $table->string('Pais');
            $table->integer('PesoTotalPickingTest');
            $table->string('Producto');
            $table->boolean('Sag');
            $table->string('Temperatura');
            $table->boolean('VerificacionCliente');
            $table->integer('Version');
            $table->integer('VidaUtil');
            $table->string('id_user');
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
        Schema::dropIfExists('agrotops');
    }
}
