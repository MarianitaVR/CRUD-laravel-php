@extends('shared/head')

@section('title', 'Listado de Compras')

@section('content')
<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        @include('components/sidebar')
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            @include('components/header')
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                @include('Compra/components/navbar')
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    <div id="kt_content_container" class="container-xxl">
                        @if (session('status'))
                        @if (session('status')==1)
                        <div class="alert alert-success">
                            meloooo
                        </div>
                        @else
                        <div class="alert alert-danger">
                            {{session('status')}}
                        </div>
                        @endif
                        @endif
                        <div class="card card-flush">
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                <div class="card-title">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                            </svg>
                                        </span>
                                        <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Buscar Compra" />
                                    </div>
                                </div>
                                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                    <div class="w-100 mw-150px">
                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Estado" data-kt-ecommerce-product-filter="status">
                                            <option></option>
                                            <option value="all">Todos</option>
                                            <option value="published">Activos</option>
                                            <option value="scheduled">Inactivos</option>
                                        </select>
                                    </div>
                                    <a href="{{route('Compra.create')}}" class="btn btn-primary">Registrar Compra</a>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="text-start min-w-100px">Id Compra</th>
                                            <th class="text-start min-w-100px">Id Proveedor </th>
                                            <th class="text-start min-w-100px">Fecha </th>
                                            <th class="text-start min-w-100px">Total </th>
                                            <th class="text-start min-w-100px"></th>
                                        </tr>
                                    </thead>

                                    <tbody class="fw-bold text-gray-600">
                                        @foreach($compras as $compra)
                                        <tr>
                                            <td class="text-start pe-0">{{$compra->idCompra}}</td>
                                            <td class="text-start pe-0">{{$compra->nombreProveedor}}</td>
                                            <td class="text-start pe-0">{{$compra->fechaCompra}}</td>
                                            <td class="text-start pe-0">{{$compra->totalCompra}}

                                                <div class="modal fade" id="editar_{{$compra->idCompra}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Detalle Compra</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="container-fluid">
                                                                    <table class="table table-striped table-hover table-bordered" id="tablaP{{isset($compra->idCompra)?$compra->idCompra:0}}">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>id</th>
                                                                                <th>Nombre</th>
                                                                                <th>Cantidad</th>
                                                                                <th>Precio</th>
                                                                                <th>Subtotal</th>
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody >



                                                                            @foreach($detalles as $key => $detalle)
                                                                            <?php
                                                                            if ($compra->idCompra == $detalle->Compra_id) {


                                                                            ?>
                                                                                <tr >
                                                                                    <td>{{$detalle->Producto_id}} </td>
                                                                                    <td>{{$detalle->nombreProducto}}</td>
                                                                                    <td >{{$detalle->cantidadProducto}}</td>
                                                                                    <td>{{$detalle->precioProducto}}</td>
                                                                                    <td>{{$detalle->precioProducto*$detalle->cantidadProducto}}</td>
                                                                                    
                                                                                </tr>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            @endforeach

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-end">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Acciones
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                </a>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <div class="menu-item px-3">
                                                        <a data-bs-toggle="modal" data-bs-target="#editar_{{$compra->idCompra}}" class="menu-link px-3">ver</a>
                                                    </div>




                                                    <div class="menu-item px-3">
                                                        <a href="{{route('Compra.edit', $compra->idCompra)}}" class="menu-link px-3">Editar</a>
                                                    </div>
                                                    <div class="menu-item px-3">


                                                        <form action="{{ route('Compra.destroy', $compra->idCompra)}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-primary " style="background-color: #00147B;" type="submit" title="Eliminar">Eliminar</button>


                                                    </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection