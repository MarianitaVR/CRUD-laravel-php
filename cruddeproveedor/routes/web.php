<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Home/view');
});

//LISTAR


Route::get('/Proveedor',[ProveedorController::Class,'list']);
Route::resource('/Proveedor',ProveedorController::Class);

Route::get('/Compra',[CompraController::Class,'list']);
Route::resource('/Compra',CompraController::Class);