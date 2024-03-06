@extends('adminlte::page')

@section('title', 'Publicações')

@section('content_header')
    <h1>Publicações</h1>
@stop

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Filtros</h3>
                    </div>
                    <form action="{{ route('publications.index') }}" method="GET">
                    <div class="card-body">


                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="titulo" class="rounded-0 form-control" placeholder="Título" value="{{ request()->get('titulo') }}">
                                </div>

                                <div class="col-md-3">
                                    <select name="tipo" class="form-control rounded-0">
                                        <option value="">Tipo</option>
                                        <option value="texto" {{ request()->get('tipo') === 'texto' ? 'selected' : '' }}>Texto</option>
                                        <option value="imagem" {{ request()->get('tipo') === 'imagem' ? 'selected' : '' }}>Imagem</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input type="text" name="autor" class="form-control rounded-0" placeholder="Autor" value="{{ request()->get('autor') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control rounded-0">
                                        <option value="">Status</option>
                                        <option value="0" {{ request()->get('status') === '0' ? 'selected' : '' }}>Criado</option>
                                        <option value="1" {{ request()->get('status') === '1' ? 'selected' : '' }}>Em Revisão</option>
                                        <option value="3" {{ request()->get('status') === '3' ? 'selected' : '' }}>Publicado</option>
                                    </select>
                                </div>

                            </div>


                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm btn-flat float-right">
                                    <i class="fas fa-search"></i>
                                    Filtrar
                                </button>
                                <a href="{{ route('publications.index') }}" class="btn btn-outline-secondary btn-sm btn-flat">
                                    Limpar Filtros
                                </a>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <h3 class="card-title">Lista de Publicações</h3>

                        <a href="{{ route('publications.create') }}" class="btn btn-success float-right btn-flat">
                            <i class="fas fa-plus-circle"></i>
                            Nova Publicação
                        </a>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table id="example1" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>@sortablelink('id','ID')</th>
                                <th>@sortablelink('titulo','Título')</th>
                                <th>@sortablelink('Tipo','Tipo')</th>
                                <th>@sortablelink('user.name','Criado por')</th>
                                <th>@sortablelink('data_lancamento','Agendamento')</th>
                                <th>@sortablelink('data_expiracao','Expira em')</th>
                                <th>@sortablelink('status','Status')</th>
                                <th>@sortablelink('publicado','Publicado?')</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($publications as $publication)
                                <tr>
                                    <td>{{ $publication->id }}</td>
                                    <td>{{ $publication->titulo }}</td>
                                    <td>{{ $publication->tipo }}</td>
                                    <td>{{ $publication->user->name }}</td>
                                    <td>{{ is_null($publication->data_lancamento) ? '-' : $publication->data_lancamento->format('d/m/Y') }}</td>
                                    <td>{{ is_null($publication->data_expiracao) ? '-' : $publication->data_expiracao->format('d/m/Y') }}</td>
                                    <td>
                                        @if($publication->status == 0)
                                            <span class="badge badge-warning">Criado</span>
                                        @elseif($publication->status == 1)
                                            <span class="badge badge-info">Em Revisão</span>
                                        @elseif($publication->status == 2)
                                            <span class="badge badge-danger">Rejeitado</span>
                                        @elseif($publication->status == 3)
                                            <span class="badge badge-success">Publicado</span>
                                        @elseif($publication->status == 4)
                                            <span class="badge badge-secondary">Agendado</span>
                                        @endif

                                    </td>
                                    <td>
                                        @if($publication->publicado)
                                            <span class="badge badge-success">Sim</span>
                                        @else
                                            <span class="badge badge-danger">Não</span>
                                        @endif
                                    </td>
                                    <td>

                                        <a href="{{ route('publications.show', $publication->id) }}" class="btn btn-info btn-sm btn-flat">
                                            <i class="fas fa-eye"></i> Detalhes
                                        </a>
{{--                                        <a href="{{ route('publications.edit', $publication->id) }}" class="btn btn-primary btn-sm">--}}
{{--                                            <i class="fas fa-edit"></i> Editar--}}
{{--                                        </a>--}}

{{--                                        <form class="form-deletar" action="{{ route('publications.destroy', $publication->id) }}" method="POST" style="display: inline;">--}}
{{--                                            @method('DELETE')--}}
{{--                                            @csrf--}}
{{--                                            <button type="submit" class="btn btn-danger btn-sm btn-deletar">--}}
{{--                                                <i class="fas fa-trash"></i> Excluir--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="8">Nenhum registro encontrado!</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
{{--                        {!! $publications->withQueryString()->links('pagination::bootstrap-5') !!}--}}
                        {!! $publications->appends(Request::except('page'))->links('pagination::bootstrap-5')  !!}
                    </div>


                </div>
                <!-- /.card -->
            </div>
        </div>

        <br>
        <br>

{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="callout callout-info">--}}
{{--                    <h5><i class="fas fa-info"></i> Histórico de postagens:</h5>--}}
{{--                    <p>Esta é a lista de todas as publicações cadastradas no sistema. Aqui você pode visualizar, editar e excluir as publicações mais antigas.</p>--}}
{{--                    <button type="button" class="btn btn-outline-info btn-flat"> Acesse o Historico</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}


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

