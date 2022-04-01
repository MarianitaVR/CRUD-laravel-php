<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedor = Proveedor::all();
        return view('proveedor.index' , ['proveedores' => $proveedor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Proveedor.registrar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nombreProveedor' => 'required',
            'telefonoProveedor' => 'required',
            'correoProveedor' => 'required',
            'direccionProveedor' => 'required',
            'estadoProveedor' => 'required',
        ]);

        Proveedor::create($request->all());
        return redirect()->route('Proveedor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);
        return view('Proveedor.editar',compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->nombreProveedor = $request->nombreProveedor;
        $proveedor->telefonoProveedor = $request->telefonoProveedor;
        $proveedor->correoProveedor = $request->correoProveedor;
        $proveedor->direccionProveedor = $request->direccionProveedor;
        $proveedor->estadoProveedor = $request->estadoProveedor;

        $proveedor->update();

        return redirect()->route('Proveedor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();
        return redirect()->route('Proveedor.index');

    }
}
