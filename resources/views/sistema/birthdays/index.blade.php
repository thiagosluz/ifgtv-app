@extends('adminlte::page')

@section('title', 'Aniversariantes')

@section('content_header')
    <h1>Aniversariante</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <h3 class="card-title">Lista de aniversários</h3>

                        <a href="{{ route('birthdays.create') }}" class="btn btn-success float-right">
                            <i class="fas fa-plus-circle"></i>
                            Novo aniversariante
                        </a>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table id="example1" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>@sortablelink('name','Nome')</th>
                                <th>@sortablelink('birthday','Aniversário')</th>
                                <th style="width:300px">Ações</th>
                            </tr>
                            </thead>
                            <tbody>

                            @php
                                \Carbon\Carbon::setlocale('pt_BR');
                            @endphp

                            @forelse($birthdays as $birthday)
                                <tr>
                                    <td>{{ $birthday->name }}</td>
                                    <td>{{ $birthday->birthday->translatedFormat('l\, j \de F') }}</td>

                                    <td>
{{--                                        <a href="{{ route('birthdays.show', $birthday->id) }}" class="btn btn-info btn-sm">--}}
{{--                                            <i class="fas fa-eye"></i> Visualizar--}}
{{--                                        </a>--}}

                                        <a href="{{ route('birthdays.edit', $birthday->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <form class="form-deletar" action="{{ route('birthdays.destroy', $birthday->id) }}" method="POST" style="display: inline;">
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
                                    <td colspan="3">Nenhum registro encontrado!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
{{--                        {!! $birthdays->withQueryString()->links('pagination::bootstrap-5') !!}--}}
                        {!! $birthdays->appends(Request::except('page'))->links('pagination::bootstrap-5')  !!}
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

