@extends('layouts.app')


@section('publics')
    <script src="{{ asset('js/finalizarPedidos.js') }}"></script>
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
            </ol>
        </nav>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
        `<div class="card-header text-center h2">{{ __('Finalizar pedido de cliente') }}</div>
            <div class="card-body">
                <form action="" method="POST">


                <div class="form-group row">
                            <label for="cliente" class="col-md-1 col-form-label text-md-left">Cliente</label>
                    {{--<select name="cliente" id="cliente"  class="cliente custom-select col-md-2 ">
                        <option data-tokens=="0">Seleccione</option>
                        <option data-tokens="julia"> julia</option>
                        <option data-tokens="adasd"> asdasdsa</option>
                        <option data-tokens="qweqeq"> qweqweqe</option>
                        <option data-tokens="pedro"> pedro</option>
                        <option data-tokens="fernando">fernando</option>
                                </select>--}}

                            <input name="cliente" id="cliente" class="form-control col-md-4"
                            value="" readonly/>

                        </div>
                <br>

        <section class="mt-3">
        <table class="table">
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
                <th scope="col">ID</th>
                <th scope="col">Producto</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Fecha fabricacion</th>
                <th scope="col">Precio por KG</th>
                <th scope="col">Destino</th>
                <th scope="col">Estado</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tbody>
          </table>
    </section>
    <br>

                <div class="form-inline row">
                            <button class="btn btn-secondary col-sm-3">Cancelar</button>
                            <button class="btn btn-primary col-sm-3 offset-md-6">Finalizar</button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
