@extends('adminlte::page')

@section('title', 'Regras')

@section('content_header')
    <h1>Regras</h1>
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
                            <dt>Nome da Regra</dt>
                            <dd>{{ $role->name }}</dd>
                        </dl>
                    </div>

                </div>

            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            Permissões da regra
                        </h3>
                    </div>

                    <div class="card-body">
                        <ul>
                            @forelse ($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @empty

                                <li>{{ $role->name == 'Super-Admin' ? 'Super Administrador' : 'Nenhuma permissão cadastrada' }}
                                </li>
                            @endforelse


                        </ul>
                    </div>

                </div>

            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Usuários da regra</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($role->users as $users)
                                    <tr>
                                        <td>{{ $users->name }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $users->id) }}" class="text-muted">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
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
