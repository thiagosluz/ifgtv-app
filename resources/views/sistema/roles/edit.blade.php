@extends('adminlte::page')

@section('title', 'Editar regra')

@section('content_header')
    <h1>Editar regra</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                @include('layouts.erros_callout')

                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Editar regra</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nome da regra" value="{{ $role->name }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="permissions">Permissões</label>
                                @error('permissions')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
{{--                                <select name="permissions[]" id="permissions" class="form-control select2bs4" multiple="multiple" data-placeholder="Selecione as permissões">--}}
                                    @foreach($permissions as $permission)
                                        <div class="form-check icheck-primary">

                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $permission->id }}"
                                                   id="permission_{{ $permission->id }}"
                                                   @if($role->permissions->contains($permission)) checked @endif >

                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right btn-flat">Atualizar</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-default btn-flat">Voltar</a>
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
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
@stop

@section('js')
{{--    @include('layouts.delete_sweetalert')--}}
{{--    @include('layouts.erros_toast')--}}
@stop

