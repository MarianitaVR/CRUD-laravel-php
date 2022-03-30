<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compras';
    protected $primaryKey = 'idCompra';
    protected $fillable = ['idProveedor','totalCompra','fechaCompra'];
    public $timestamps = false;
}
