@extends('adminlte::page')

@section('title', 'Aniversariantes')

@section('content_header')
    <h1>Aniversariante</h1>
@stop

@section('content')

    {{-- div para a pesquisa dos aniversariantes --}}
    <div class="div container-fluid">
        <div class="row">
            <div class="col-md-12">
                {{-- adicionar um card --}}
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Pesquisar aniversariantes</h3>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('birthdays.index') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <input
                                        type="text"
                                        name="search_name"
                                        id="search-name"
                                        class="form-control"
                                        placeholder="Nome do aniversariante"
                                        value="{{ request()->get('search_name') }}"
                                        aria-label="Nome do aniversariante">
                                </div>
                                <div class="col-md-3">
                                    <input
                                        autocomplete="off"
                                        type="text"
                                        name="start_date"
                                        id="start-date"
                                        class="form-control"
                                        placeholder="Data Inicial"
                                        value="{{ request()->get('start_date') }}"
                                        aria-label="Data Inicial">
                                </div>
                                <div class="col-md-3">
                                    <input
                                        autocomplete="off"
                                        type="text"
                                        name="end_date"
                                        id="end-date"
                                        class="form-control"
                                        placeholder="Data Final"
                                        value="{{ request()->get('end_date') }}"
                                        aria-label="Data Final">
                                </div>
                                <div class="col-md-2">
{{--                                    botão de limpar --}}
                                    <a href="{{ route('birthdays.index') }}" class="btn btn-outline-secondary btn-flat">
                                        <i class="fas fa-eraser"></i> Limpar
                                    </a>
                                    <button class="btn btn-success btn-flat" type="submit">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de Aniversariantes --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Lista de aniversários</h3>
                        <div class="float-right">
                            <a href="{{ route('birthdays.export', ['search_name' => request()->get('search_name'), 'start_date' => request()->get('start_date'), 'end_date' => request()->get('end_date')]) }}" class="btn btn-secondary btn-flat">
                                <i class="fas fa-file-export"></i> Exportar
                            </a>

                            <a href="{{ route('birthdays.create') }}" class="btn btn-success btn-flat">
                                <i class="fas fa-plus-circle"></i> Novo aniversariante
                            </a>
                            <form action="{{ route('birthdays.runPostAniversario') }}" method="POST" id="form-post-aniversario" style="display:inline-block;">
                                @csrf
                                <button type="button" id="btn-post-aniversario" class="btn btn-warning btn-flat">
                                    <i class="fas fa-bolt"></i> Gerar Post de Aniversariantes (Manual)
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <form id="mass-delete-form" action="{{ route('birthdays.destroyMany') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <button type="button" id="btn-mass-delete" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Deletar Selecionados
                                </button>
                            </div>
                            <table id="example1" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    @if(request()->get('search'))
                                        <th>Nome</th>
                                        <th>Aniversário</th>
                                        <th style="width:300px">Ações</th>
                                    @else
                                        <th>@sortablelink('name','Nome')</th>
                                        <th>@sortablelink('birthday','Aniversário')</th>
                                        <th style="width:300px">Ações</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    \Carbon\Carbon::setlocale('pt_BR');
                                @endphp

                                @forelse($birthdays as $birthday)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="{{ $birthday->id }}"></td>
                                        <td>{{ $birthday->name }}</td>
                                        <td>{{ $birthday->birthday->translatedFormat('l, j \de F') }}</td>
                                        <td>
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
                                        <td colspan="4">Nenhum registro encontrado!</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        {!! $birthdays->appends(Request::except('page'))->links('pagination::bootstrap-5') !!}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
    @include('layouts.delete_sweetalert')
    @include('layouts.erros_toast')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        // Inicializando os datepickers
        $('#start-date, #end-date').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            autoclose: true,
            todayHighlight: true
        });

        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="ids[]"]');
            for (const cb of checkboxes) {
                cb.checked = this.checked;
            }
        });

        // SweetAlert para deletar em massa
        document.getElementById('btn-mass-delete').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('mass-delete-form');
            if (document.querySelectorAll('input[name="ids[]"]:checked').length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selecione pelo menos um aniversariante!',
                    showConfirmButton: true
                });
                return;
            }
            Swal.fire({
                title: 'Você tem certeza?',
                text: 'Você não poderá reverter isso!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // SweetAlert para gerar posts de aniversariantes
        document.getElementById('btn-post-aniversario').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Gerar posts de aniversariantes do dia?',
                text: 'Isso irá excluir e recriar os posts de aniversário do dia!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, gerar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-post-aniversario').submit();
                }
            });
        });
    </script>
@stop
