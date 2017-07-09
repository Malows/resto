<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('mesa');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->json('platos');
            $table->timestamps();
            $table->timestamp('listo_at')->nullable();
            $table->timestamp('cobrado_at')->nullable();
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
        Schema::dropIfExists('pedidos');
    }
}
