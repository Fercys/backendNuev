<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSacosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sacos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ColorHilo');
            $table->string('Descripcion');
            $table->integer('IdSaco');
            $table->string('Nombre');
            $table->integer('Peso');
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
        Schema::dropIfExists('sacos');
    }
}
