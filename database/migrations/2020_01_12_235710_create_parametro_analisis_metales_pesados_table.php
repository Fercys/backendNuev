<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametroAnalisisMetalesPesadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametro_analisis_metales_pesados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('MaxValidValue');
            $table->integer('MinValidValue');
            $table->string('Nombre');
            $table->string('Nombre_en');
            $table->string('UM');
            $table->string('UM_en');
            $table->unsignedBigInteger('id_agrotop')->unsigned();
            $table->foreign('id_agrotop')
            ->references('id')
            ->on('agrotops')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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
        Schema::dropIfExists('parametro_analisis_metales_pesados');
    }
}
