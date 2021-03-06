@extends('layouts.app')

@section('publics')
    <script src="{{ asset('js/pesajeInicialDespacho.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('js/notifCartel.js') }}"></script>
    <script src="{{ asset('js/errorCartel.js') }}"></script>
@endsection

@section('content')


<div class="container">
    <div class="bs-example">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" >Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('balanzas.menu')}}" >Balanzas</a></li>
                <li class="breadcrumb-item"><a href="{{route('despachos.index')}}" >Gestion de despacho</a></li>
                <li class="breadcrumb-item active">Nuevo despacho</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
        `<div class="card-header text-center h2">{{ __('Pesaje inicial despacho de productos') }}</div>
            <div class="card-body">
                <form action="{{route('despachos.store')}}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="cliente" class="col-md-1 col-form-label text-md-left c">Cliente</label>
                        <select name="cliente" id="cliente"  class="custom-select col-md-4 cliente_select">
                            <option data-tokens=="0">Seleccione</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{$cliente->id}}"> {{$cliente->denominacion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row d-flex justify-content-center">
                        <table class="table table-light mt-2 offset-1">
                              @if ($errors->any())
                              <div class="alert alert-danger">
                                 {{$errors->first()}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              @endif
                            @if (session('error'))
                            <div class="">
                            <p class="errorjs" style="display:none">{{ session('error') }}</p>
                            </div>
                            @endif

                            @if (session('mensaje'))
                            <div class="" role="alert">
                            <p class="alertajs" style="display:none">{{ session('mensaje') }}</p>
                            </div>
                            @endif

                            <thead>
                              <tr>
                                <th scope="col">Orden</th>
                                <th scope="col">Fecha entrega</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Cant. disponible</th>
                              </tr>
                            </thead>
                            <tbody class="tbodyop">

                            </tbody>
                          </table>

                    </div>

                    <div class="form-inline row mt-5 offset-0">

                        <label for="producto_id" class="col-md-2 col-form-label text-md-right">Orden</label>
                        <select name="id_ordenproduccion" id="id_ordenproduccion" class="custom-select col-md-2 selectop">
                            <option data-tokens=="0">Seleccione</option>
                        </select>

                        <label for="producto_id" class="col-md-2 col-form-label text-md-left">Producto</label>
                        <input id="producto_id" type="text" class="form-control col-md-4 nombreprod"  name="producto_id" placeholder="Producto seleccionado" readonly required>

                    </div>

                    <div class="form-inline row mt-5 offset-0">
                        <label for="Transportista" class="col-md-2 col-form-label text-md-left">Transportista</label>
                            <select name="Transportista" id="transportista_id"  class="custom-select col-md-4 ">
                                <option data-tokens=="0">Seleccione</option>
                                @foreach ($transportistas as $transportista)
                                    <option value="{{$transportista->id}}"> {{$transportista->empresa()->first()->denominacion}}</option>
                                @endforeach
                            </select>

                        <label for="patente" class="col-md-2 col-form-label text-md-right">Patente</label>
                        <input id="patente" type="text" class="form-control col-md-2 patentejs"  name="patente" value="{{old('patente')}}" placeholder="abc123 / ab123ab" pattern="[A-Za-z]{3}[0-9]{3}|[a-zA-Z]{2}[0-9]{3}[a-zA-Z]{2}" required>
                    </div>

                    <div class="form-inline row mt-5 offset-0">
                        <label for="tara" class="col-md-2 col-form-label text-md-right">Peso vehiculo</label>
                        <input id="tara" type="text" class="form-control col-md-1 border-left tarajs"  name="tara" placeholder="Tara" required readonly>
                        <label for="" class="col-form-label text-md-right"> Kg </label>

                        <a class="pesajeAleatorio btn btn-success btn-block col-sm-2 offset-1" >leer pesaje</a>

                    </div>
                    <br>
                    <br>

                    <div class="form-inline row">
                        <a class="btn btn-secondary col-sm-3" href="{{route('despachos.index')}}">Cancelar</a>
                        <button type="submit" class="btn btn-primary col-sm-3 offset-md-6">Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
