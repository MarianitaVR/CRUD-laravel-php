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
        Schema::create('detalleCompras', function (Blueprint $table) {
            $table->bigIncrements('idDetalleCompra');
                $table->BigInteger('Producto_id')->unsigned();
                $table->BigInteger('Compra_id')->unsigned();
                $table->smallInteger('cantidadProducto');
                $table->double('precioProducto');
                
                $table->foreign('Compra_id')->references('idCompra')->on('compras');
                $table->foreign('Producto_id')->references('idProducto')->on('productos');
    
                
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
