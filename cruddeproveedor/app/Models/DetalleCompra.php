<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalleCompras';
    protected $primaryKey = 'idDetalleCompra';
    protected $fillable = ['Producto_id', 'Compra_id', 'cantidadProducto', 'precioProducto'];
    public $timestamps = false;
}
