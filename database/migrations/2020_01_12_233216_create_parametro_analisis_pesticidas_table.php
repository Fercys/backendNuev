<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametroAnalisisPesticidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametro_analisis_pesticidas', function (Blueprint $table) {
            $table->bigIncrements('id');
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
        Schema::dropIfExists('parametro_analisis_pesticidas');
    }
}
