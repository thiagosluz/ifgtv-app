@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <h3 class="card-title">Lista de Usuários</h3>

                        <a href="{{ route('users.create') }}" class="btn btn-success float-right">
                            <i class="fas fa-plus-circle"></i>
                            Novo Usuário
                        </a>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table id="example1" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>@sortablelink('id','ID')</th>
                                <th>@sortablelink('name','Nome')</th>
                                <th>@sortablelink('email','Email')</th>
                                <th>Setor</th>
                                <th>Regra</th>
                                <th style="width:300px">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
{{--                                    se não for nulo, mostrar o nome do setor --}}
                                    <td>{{ $user->setor->nome ?? '' }}</td>

                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>

                                    <td>
                                        @if(!$user->hasRole('Super-Admin'))
{{--                                            temporariamente desabilitada, por não haver necessidade--}}
{{--                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">--}}
{{--                                                <i class="fas fa-eye"></i> Visualizar--}}
{{--                                            </a>--}}
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>

                                            <form class="form-deletar" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm btn-deletar">
                                                    <i class="fas fa-trash"></i> Deletar
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">Nenhum registro encontrado!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
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

