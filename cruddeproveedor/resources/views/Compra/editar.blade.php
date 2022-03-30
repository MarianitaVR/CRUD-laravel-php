<!-- Aca estamos utilizando el codigo que hay en la carpeta shared y el archico head -->
@extends('shared/head')

@section('title', 'Editar Compra')

@section('content')
<div class="d-flex flex-column flex-root">
  <div class="page d-flex flex-row flex-column-fluid">
    @include('components/sidebar')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
      @include('components/header')
      <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('Proveedor/components/navbar')

        <!-- Codigo de formulario para el registro -->
        <div class="post d-flex flex-column-fluid" id="kt_post">
          <div id="kt_content_container" class="container-xxl">
            <form action="{{ route('Compra.update',$compra->idCompra)}}" method="post" id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row">
              @csrf
              {{method_field('PATCH')}}
              <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                      <div class="card card-flush py-4">
                        <div class="card-header">
                          <div class="card-title">
                            <h2>Información de la compra</h2>
                          </div>
                        </div>

                        <div class="card-body pt-0">
                          <div class="d-flex flex-wrap gap-5">
                            <div class="fv-row w-100 flex-md-root">
                              <label class="required form-label">Proveedor</label>
                              <select class="form-select mb-3" name="idProveedor" data-control="select2" data-hide-search="true" data-placeholder="Proveedor">
                                <option></option>
                                @foreach($proveedores as $proveedor)

                                <option <?php

                                        if ($proveedor->idProveedor == $compra->idProveedor) {
                                          ?>selected <?php
                                                    }

                                                    ?>value="{{$proveedor->idProveedor}}">{{$proveedor->nombreProveedor}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                              <label class="required form-label">Fecha </label>
                              <input type="date" name="fechaCompra" class="form-control mb-3" placeholder="Fecha " value="{{$compra->fechaCompra}}" />
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                              <label class="required form-label">Precio Total</label>
                              <input type="number" name="totalCompra" id="total_compra{{isset($compra->idCompra)?$compra->idCompra:0}}" class="form-control mb-3" placeholder="precio total" value="{{$compra->totalCompra}}" readonly />
                            </div>
                          </div>
                        </div>

                        <div class="card-body pt-0">
                          <div class="d-flex flex-wrap gap-5">
                            <div class="fv-row w-100 flex-md-root">
                              <label class="required form-label">Producto:</label>
                              <select class="form-select mb-2" id="producto_id{{isset($compra->idCompra)?$compra->idCompra:0}}" name="idProducto" data-control="select2" data-hide-search="true" data-placeholder="Producto" onchange="colocar_precio(<?php echo isset($compra->idCompra) ? $compra->idCompra : 0 ?>)">
                                <option></option>
                                @foreach($productos as $producto)
                                <option precio="{{$producto->precioProducto}}" value="{{$producto->idProducto}}">{{$producto->nombreProducto}}</option>
                                @endforeach
                              </select>
                            </div>

                            <div class="fv-row w-100 flex-md-root">
                              <label class="required form-label">cantidad </label>
                              <input type="number" id="cantidad_detalle_compra{{isset($compra->idCompra)?$compra->idCompra:0}}" class="form-control mb-2" value="" />
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                              <label class="required form-label">precio </label>
                              <input type="number" name="precio_detalle_compra" id="precio_detalle_compra{{isset($compra->idCompra)?$compra->idCompra:0}}" class="form-control mb-2" value="" readonly />
                            </div>
                          </div>
                        </div>


                        <div class="card-body pt-0">
                          <div class="d-flex flex-wrap gap-5">
                            <div class="fv-row w-100 flex-md-root">
                              <div class="col-12 mb-2 text-white">
                                <input type="button" onclick="agregar_producto(<?php echo isset($compra->idCompra) ? $compra->idCompra : 0 ?>)" id="agregarbtn" name="" value="Agregar" class="form-control btn " style="background-color:#000C79; color: white;">
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="post d-flex flex-column-fluid" style="" id="kt_post">
                          <div id="kt_content_container" class="container-xxl">
                            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                              <div class="tab-content">
                                <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                                  <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <div class="card card-flush py-4" style="border: 1px solid #E0E0E0">
                                      <div class="card-header">
                                        <div class="card-title">
                                          <h2>Lista de Productos</h2>
                                        </div>
                                      </div>


                                      <div class="card-body pt-0">
                                        <div class="row">
                                          <div class="col-12 mb-2">
                                            <table class="table table-striped table-hover table-bordered" id="tablaP{{isset($compra->idCompra)?$compra->idCompra:0}}">
                                              <thead>
                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                  <th class="text-start min-w-100px">id</th>
                                                  <th class="text-start min-w-100px">Nombre</th>
                                                  <th class="text-start min-w-100px">Cantidad</th>
                                                  <th class="text-start min-w-100px">Precio</th>
                                                  <th class="text-start min-w-100px">Subtotal</th>
                                                  <th class="text-start min-w-100px">Opciones</th>
                                                </tr>
                                              </thead>
                                              <tbody class="fw-bold text-gray-600" id="tablaProductos{{isset($compra->idCompra)?$compra->idCompra:0}}">



                                                @foreach($detalles as $key => $detalle)
                                                <?php
                                                if ($compra->idCompra == $detalle->Compra_id) {


                                                  ?>
                                                  <tr id="tr{{isset($compra->idCompra)?$compra->idCompra:0}}_{{$detalle->Producto_id}}">
                                                    <td>
                                                      <input type="hidden" name="productos_id[]" value="{{$detalle->Producto_id}}" />
                                                      <input type="hidden" name="cantidades[]" id="cantidadDetalle{{isset($compra->idCompra)?$compra->idCompra:0}}_{{$detalle->Producto_id}}" value="{{$detalle->cantidadProducto}}" />
                                                      {{$detalle->Producto_id}}
                                                    </td>
                                                    <td>
                                                      {{$detalle->nombreProducto}}
                                                    </td>
                                                    <td id="cd{{isset($compra->idCompra)?$compra->idCompra:0}}_{{$detalle->Producto_id}}">{{$detalle->cantidadProducto}}</td>
                                                    <td id="st{{isset($compra->idCompra)?$compra->idCompra:0}}_{{$detalle->Producto_id}}">{{$detalle->precioProducto}}</td>
                                                    <td>{{$detalle->precioProducto*$detalle->cantidadProducto}}</td>
                                                    <td>

                                                      <button type="button" class="btn btn-danger" onclick="eliminar_producto(<?php echo $detalle->Producto_id  ?>,<?php echo $detalle->precioProducto * $detalle->cantidadProducto  ?>, <?php echo isset($compra->idCompra) ? $compra->idCompra : 0 ?>)">
                                                        Eliminar producto
                                                      </button>



                                                    </td>
                                                  </tr>
                                                <?php
                                              }
                                              ?>
                                                @endforeach

                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-5">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- Bonotes -->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <a href="{{route('Compra.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                  <button type="submit" name="btnregistrar" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">Registrar</span>
                  </button>
                </div>
              </div>
              
          </div>
        </div>
        <!--fin-->
      </div>
    </div>
    </form>
  </div>
</div>

</div>
</div>