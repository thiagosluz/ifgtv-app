@extends('adminlte::page')

@section('title', 'Regras')

@section('content_header')
    <h1>Permissões</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            Descrição
                        </h3>
                    </div>

                    <div class="card-body">
                        <dl>
                            <dt>Nome da Permissão</dt>
                            <dd>{{ $permission->name }}</dd>
                        </dl>
                    </div>

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
