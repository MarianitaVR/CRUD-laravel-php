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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->bigIncrements('idProveedor');
            $table->string('nombreProveedor',50);
            $table->string('telefonoProveedor',20);
            $table->string('correoProveedor',40);
            $table->string('direccionProveedor',40);
            $table->boolean('estadoProveedor')->default(1);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedors');
    }
};
