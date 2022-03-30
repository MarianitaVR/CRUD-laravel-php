<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\DetalleCompra;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\DB;
use Exception;


class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $datos['compras'] = DB::table('compras')
            ->join('proveedores', 'compras.idProveedor', '=', 'proveedores.idProveedor')
            ->select('compras.*', 'proveedores.nombreProveedor')
            ->get();
            $datos['detalles'] = DB::table('detallecompras')
            ->join('productos', 'detallecompras.Producto_id', '=', 'productos.idProducto')
            ->select('*')
            ->get();
        return view('compra.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datos['proveedores'] = Proveedor::all();
        $datos['productos'] = Producto::all();
        return view('Compra.registrar', $datos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        try {
            DB::beginTransaction();
            $compra = Compra::insertGetId([
                "idProveedor" => $input["idProveedor"],
                "fechaCompra" => $input["fechaCompra"],
                "totalCompra" => $this->calcular_precio($input["productos_id"], $input["cantidades"]),

            ]);

            foreach ($input["productos_id"] as $key => $producto) {
                $P = Producto::find($producto);
                DetalleCompra::create([
                    "cantidadProducto" => $input["cantidades"][$key],
                    "precioProducto" => ($P->precioProducto * $input["cantidades"][$key]),
                    "Compra_id" => $compra,
                    "Producto_id" => $producto
                ]);
                if ($P->stock > $input["cantidades"][$key]) {
                    $P->update(["stock" => $P->stock - $input["cantidades"][$key]]);
                } else {
                    throw new Exception('Cantidad excedida.');
                }
            }

            DB::commit();
            return redirect("/Compra")->with('status', '1');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("/Compra")->with('status', $e->getMessage());
        }
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



        $datos['compra'] = Compra::find($id);
        $datos['proveedores'] = Proveedor::all();
        $datos['productos'] = Producto::all();
        $datos['detalles'] = DetalleCompra::where('Compra_id', $id)
            ->join('productos', 'detallecompras.Producto_id', '=', 'productos.idProducto')
            ->select('*')
            ->get();
        return view('Compra.editar', $datos);
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

        $input = $request->all();


        try {
            DB::beginTransaction();
            Compra::where('idCompra', '=', $id)->update([
                "idProveedor" => $input["idProveedor"],
                "fechaCompra" => $input["fechaCompra"],
                "totalCompra" => $this->calcular_precio($input["productos_id"], $input["cantidades"]),
            ]);

            foreach ($input["productos_id"] as $key => $producto) {
                $P = Producto::find($producto);


                $cantidad_detalle = DB::table('detallecompras')
                    ->select('*')
                    ->where('Compra_id', '=', $id)
                    ->where('Producto_id', '=', $P->idProducto)
                    ->get();

                if (isset($cantidad_detalle[0])) {
                    if ($P->stock > $input["cantidades"][$key]) {

                        if ($input["cantidades"][$key] < $cantidad_detalle[0]->cantidadProducto) {
                            $P->update(["existenciaProducto" => $P->stock + ($cantidad_detalle[0]->cantidadProducto - $input["cantidades"][$key])]);
                        } else if (($input["cantidades"][$key] > $cantidad_detalle[0]->cantidadProducto)) {
                            $P->update(["stock" => $P->stock - ($input["cantidades"][$key] - $cantidad_detalle[0]->cantidadProducto)]);
                        }
                    } else {
                        throw new Exception('Cantidad excedida.');
                    }
                } else {
                    $P->update(["stock" => $P->stock - $input["cantidades"][$key]]);
                }




                DetalleCompra::updateOrCreate(
                    [
                        "Compra_id" => $id,
                        "Producto_id" => $producto
                    ],
                    [
                        "cantidadProducto" => $input["cantidades"][$key],
                        "precioProducto" => ($P->precioProducto * $input["cantidades"][$key])
                    ]

                );
            }



            $Ds = DB::table('detallecompras')
                ->select('*')
                ->where('Compra_id', '=', $id)
                ->get();


            foreach ($input["productos_id"] as $key => $producto) {
                foreach ($Ds as $key => $D) {

                    if ($D->Producto_id == $producto) {
                        unset($Ds[$key]);
                    }
                }
            }

            foreach ($Ds as $D) {
                $P = Producto::find($D->Producto_id);
                DetalleCompra::where('idDetalleCompra', $D->idDetalleCompra)->delete();
                $P->update(["stock" => $P->stock + $D->cantidadProducto]);
            }


            DB::commit();
            return redirect("/Compra")->with('status', '1');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("/Compra")->with('status', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {



        try {
            DB::beginTransaction();

            $Ds = DB::table('detallecompras')
                ->select('*')
                ->where('Compra_id', '=', $id)
                ->get();

            foreach ($Ds as $D) {
                $P = Producto::find($D->Producto_id);
                $P->update(["stock" => $P->stock + $D->cantidadProducto]);
                DetalleCompra::where('idDetalleCompra', $D->idDetalleCompra)->delete();
            }


            Compra::where('idCompra', $id)->delete();

            DB::commit();
            return redirect("/Compra")->with('status', '1');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("/Compra")->with('status', $e->getMessage());
        }
    }

    public function calcular_precio($productos, $cantidad)
    {
        $precio = 0;
        foreach ($productos as $key => $producto) {
            $P = Producto::find($producto);
            $precio += ($P->precioProducto * $cantidad[$key]);
        }

        return $precio;
    }
}
