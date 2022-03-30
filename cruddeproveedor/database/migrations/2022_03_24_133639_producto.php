<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('idProducto');
            $table->BigInteger('idCategoria')->unsigned();
            $table->string('nombreProducto');
            $table->string('descripcionProducto');
            $table->smallInteger('stock');
            $table->double('precioProducto');
            $table->boolean('estadoProducto')->default(1);
            $table->foreign('idCategoria')->references('idCategoria')->on('categoriaProducto');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
