@extends('adminlte::page')

@section('title', 'Regras')

@section('content_header')
    <h1>Permissões</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <h3 class="card-title">Lista de Permissões</h3>

                        <a href="{{ route('permissions.create') }}" class="btn btn-success float-right">
                            <i class="fas fa-plus-circle"></i>
                            Nova Permissão
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
                            @forelse($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>

                                    <td>
                                        <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Visualizar
                                        </a>
                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <form class="form-deletar" action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display: inline;">
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
                        {!! $permissions->withQueryString()->links('pagination::bootstrap-5') !!}
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

