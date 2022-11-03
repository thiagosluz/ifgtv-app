@extends('adminlte::page')

@section('title', 'Regras')

@section('content_header')
    <h1>Regras</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <h3 class="card-title">Lista de Regras</h3>

                        <a href="{{ route('roles.create') }}" class="btn btn-success float-right">
                            <i class="fas fa-plus-circle"></i>
                            Nova Regra
                        </a>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table id="example1" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th style="width:300px">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>

                                    <td>
                                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Visualizar
                                        </a>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <form class="form-deletar" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm btn-deletar">
                                                <i class="fas fa-trash"></i> Deletar
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="2">Nenhum registro encontrado!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        {!! $roles->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>


                </div>
                <!-- /.card -->
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

