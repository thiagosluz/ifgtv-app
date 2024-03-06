@extends('adminlte::page')

@section('title', 'Atualizar permissão')

@section('content_header')
    <h1>Atualizar permissão</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                @include('layouts.erros_callout')

                <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Atualizar permissão</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nome da permissão" value="{{ $permission->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right btn-flat">Atualizar</button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-default btn-flat">Voltar</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@stop

@section('footer')
        {{ config('adminlte.title') }} &copy; @php(print date('Y'))
@stop

@section('adminlte_css')
{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
@stop

@section('js')
{{--    @include('layouts.delete_sweetalert')--}}
{{--    @include('layouts.erros_toast')--}}
@stop

