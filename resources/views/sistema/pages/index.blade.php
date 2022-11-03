@extends('adminlte::page')

@section('title', 'Pages')

@section('content_header')
    <h1>Pages</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <h3 class="card-title">Lista de Menus</h3>

                        <a href="{{ route('pages.create') }}" class="btn btn-success float-right">
                            <i class="fas fa-plus-circle"></i>
                            Novo Menu
                        </a>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table id="example1" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Ordem</th>
                                <th>Texto</th>
                                <th>URL</th>
                                <th>Icone</th>
                                <th>Permissão</th>

                                <th style="width:300px">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($pages as $page)
                                <tr>
                                    <td>{{ $page->order }}</td>
                                    <td>{{ $page->text }}</td>
                                    <td>{{ $page->url }}</td>
                                    <td><i class="{{ $page->icon }}"></i></td>
                                    <td>{{ $page->can }}</td>

                                    <td>
                                        <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <form class="form-deletar" action="{{ route('pages.destroy', $page->id) }}" method="POST" style="display: inline;">
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
                        {!! $pages->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>


                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            Ordenar Menu
                        </h3>
                    </div>

                    <div class="card-body">
                        <ul class="todo-list ui-sortable" data-widget="todo-list">
                            @forelse($pages as $page)
                                <li data-id="{{ $page->order }}" id="{{ $page->id }}">
                                    <span class="handle ui-sortable-handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <i class="{{ $page->icon }}"></i>
                                    <span class="text">{{ $page->text }}</span>
                                </li>
                            @empty
                            @endforelse


                        </ul>
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
@stop

@section('js')
    @include('layouts.delete_sweetalert')
    @include('layouts.erros_toast')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script>
        $('.todo-list').sortable({
            opacity: '0.5',
            update: function(e, ui){
                newOrder = $(this).sortable("toArray");
                console.log(newOrder);
                $.ajax({
                    url: "{{ route('pages.order') }}",
                    type: "POST",
                    data: {
                        order:  $(this).sortable("toArray"),
                        _token: "{{ csrf_token() }}",
                    },
                    // complete: function(){},
                    success: function(feedback){
                        console.log(feedback);
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                        toastr.success(feedback);
                    }
                });
            }
        });
    </script>
@stop


