@extends('adminlte::page')

@section('title', 'Novo Setor')

@section('content_header')
    <h1>Novo Setor</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                @include('layouts.erros_callout')

                <form action="{{ route('setores.store') }}" method="POST">
                    @csrf
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Novo Setor</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="nome">Nome do Setor</label>
                                <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" placeholder="Nome do Setor" value="{{ old('nome') }}">
                                @error('nome')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right btn-flat">Salvar</button>
                            <a href="{{ route('setores.index') }}" class="btn btn-default btn-flat">Voltar</a>
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
    {{-- Include any additional CSS here --}}
@stop

@section('js')
    {{-- Include any additional scripts here --}}
@stop
