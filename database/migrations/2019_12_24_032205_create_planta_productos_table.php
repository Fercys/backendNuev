<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planta_productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cantidad_kg')->nullable();
            $table->unsignedBigInteger('id_producto')->unsigned();
            $table->foreign('id_producto')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_planta')->unsigned();
            $table->foreign('id_planta')
                ->references('id')
                ->on('planta')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamp('date_desde')->nullable();
            $table->timestamp('date_hasta')->nullable();
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
        Schema::dropIfExists('planta_productos');
    }
}
