<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavieraPuertoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('naviera__puertos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_naviera')->unsigned();
            $table->foreign('id_naviera')
            ->references('id')
            ->on('navieras')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->unsignedBigInteger('id_puerto')->unsigned();
            $table->foreign('id_puerto')
            ->references('id')
            ->on('puertos')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->integer('dias');
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
        Schema::dropIfExists('naviera__puertos');
    }
}
