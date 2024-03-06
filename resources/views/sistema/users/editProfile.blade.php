@extends('adminlte::page')

@section('title', 'Editar Usuário')

@section('content_header')
    <h1>Meu Usuário</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                @include('layouts.erros_callout')

                <form action="{{ route('profile.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Editar meu usuário</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nome do usuário" value="{{ $user->name }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail do usuário" value="{{ $user->email }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Senha do usuário">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Senha</label>
                                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmar senha do usuário">
                                @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="receber_notificacoes">Receber emails de aprovação de publicações?</label>
                                <input id="receber_notificacoes" name="receber_notificacoes" type="checkbox" @if( $user->receber_notificacoes ) checked @endif
                                data-toggle="toggle"
                                       data-on="SIM"
                                       data-off="NÃO"
                                       data-size="xs"
                                       data-onstyle="outline-success"
                                       data-offstyle="outline-danger">
                                @error('receber_notificacoes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right btn-flat">Atualizar</button>
{{--                            <a href="{{ route('users.index') }}" class="btn btn-default">Voltar</a>--}}
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
{{--    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">--}}
{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
{{--    @include('layouts.delete_sweetalert')--}}
{{--    @include('layouts.erros_toast')--}}
@stop

