@extends('adminlte::page')

@section('title', 'Erro 402 - Pagamento necessário')

@section('content_header')
    <h1>Erro 402 - Pagamento necessário</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <strong>Erro 402:</strong> Pagamento necessário para acessar este recurso.
                </div>
            </div>
        </div>
    </div>
    @stop

    @section('footer')
        {{ config('adminlte.title') }} &copy; @php(print date('Y'))
@stop

@section('adminlte_css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop

@section('js')
    @include('layouts.delete_sweetalert')
    @include('layouts.erros_toast')
@stop
