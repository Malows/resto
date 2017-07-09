<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->float('precio');
            $table->string('descripcion')->nulleable();
            $table->string('foto');
            $table->boolean('habilitado')->default(true);
            $table->unsignedInteger('categoria_plato_id');
            $table->foreign('categoria_plato_id')->references('id')->on('categorias_platos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platos');
    }
}
