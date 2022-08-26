@extends('adminlte::page')

@section('title', 'Publicação')

@section('content_header')
    <h1>Publicação</h1>
@stop

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            Ações
                        </h3>
                    </div>
                    <div class="card-body pad">
                    {{--controles de ações--}}

                        <div class="btn-group">
                            <a href="{{ route('publications.index') }}" class="btn btn-outline-light btn-flat">
                                <i class="fas fa-arrow-left"></i>
                                Voltar
                            </a>
                        </div>

{{--                    permission:publications-publicar--}}
                        @can('publications-publicar')
                        <div class="btn-group">
                            <form action="{{ route('publications.publicar', $publication->id) }}" method="POST">
                                @csrf
                                @if($publication->publicado == 0)
                                <button id="btn_submit"  type="submit" class="btn btn-outline-success btn-flat" data-toggle="tooltip" title="Aprovando, será exibido em todas as TVs"><i class="fas fa-check"></i> Aprovar publicação</button>
                                @else
                                <button class="btn btn-outline-success btn-flat" data-toggle="tooltip" title="Aprovando, será exibido em todas as TVs" disabled><i class="fas fa-check"></i> Publicação já aprovada</button>
                                @endif

                                <button type="button" class="btn btn-outline-success btn-flat" id="btn_waiting" style="display: none" disabled="disabled">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Salvando...
                                </button>
                            </form>
                        </div>
                        @endcan


{{--                    permission:publications-edit--}}
                        @can('publications-edit')
                            @if($publication->publicado == 0)
                                <div class="btn-group">
                                    <a href="{{ route('publications.edit', $publication->id) }}" class="btn btn-outline-warning btn-flat">
                                        <i class="fas fa-edit"></i>
                                        Editar
                                    </a>
                                </div>
                            @endif
                        @endcan

{{--                    permission:publications-previa--}}
                        @can('publications-previa')
                        <div class="btn-group">
                            <a href="{{ route('publications.previa', $publication->id) }}" class="btn btn-primary btn-flat" data-toggle="tooltip" title="Prévia de como ficará a postagem nas TVs">
                                <i class="fas fa-eye"></i>
                                Visualizar
                            </a>
                        </div>
                        @endcan

{{--                    permission:publications-delete ou permission:publications-moderador --}}
                        @can('publications-delete')
                        <div class="btn-group float-right">
                            <form class="form-deletar" action="{{ route('publications.destroy', $publication->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-flat btn-deletar">
                                    <i class="fas fa-trash"></i>
                                    Excluir
                                </button>
                            </form>
                        </div>
                        @endcan

                    {{--fim de controles de ações--}}


                    </div>

                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn"></i>
                                    #{{ $publication->id }}
                                </h3>
                            </div>

                            <div class="card-body">

                                <div class="callout callout-success">
                                    <h5>Título</h5>
                                    <p>{{ $publication->titulo }}</p>
                                </div>

                                <div class="callout callout-info">
                                    <h5>Texto</h5>
                                    <p>{!! $publication->texto !!}</p>
                                </div>

                            </div>

                        </div>

                    </div>

                    @if($publication->tipo === 'imagem')
                        <div class="col-md-12">
                            <div class="card card-widget">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <img class="img-fluid pad" src="{{ asset('publish/tv/' . $publication->imagem)  }} " alt="Photo">
                                </div>

                            </div>

                        </div>
                    @endif

                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bullhorn"></i>

                        </h3>
                    </div>

                    <div class="card-body">

                        <div class="callout callout-warning">
                            <h5>Informações</h5>
                            <p>
                            <dl>
                                <dt>Autor</dt>
                                <dd>{{ $publication->user->name }}</dd>
                                <dt>Criado em</dt>
                                <dd>{{ $publication->created_at->format('d/m/Y') }}</dd>
                                <dt>Expira em</dt>
                                <dd>{{ is_null($publication->data_expiracao) ? '-' : $publication->data_expiracao->format('d/m/Y') }}</dd>
                                <dt>Tipo</dt>
                                <dd>{{ $publication->tipo }}</dd>
                                <dt>Status</dt>
                                <dd>
                                    @if($publication->status == 0)
                                        <span class="badge badge-warning">Criado</span>
                                    @elseif($publication->status == 1)
                                        <span class="badge badge-info">Em Revisão</span>
                                    @elseif($publication->status == 2)
                                        <span class="badge badge-danger">Rejeitado</span>
                                    @elseif($publication->status == 3)
                                        <span class="badge badge-success">Publicado</span>
                                    @endif
                                </dd>

                                <dt>Publicado</dt>
                                <dd>
                                    @if($publication->publicado)
                                        <span class="badge badge-success">Sim</span>
                                    @else
                                        <span class="badge badge-danger">Não </span>
                                    @endif
                                </dd>
                            </dl>

                            </p>
                        </div>




                    </div>

                </div>

            </div>



        </div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">


                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bullhorn"></i>
                           Histórico de modificações
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="timeline">


                            @foreach($publication->history as $log)

                                <div class="time-label">
                                    @php
                                        \Carbon\Carbon::setlocale('pt_BR');
                                    @endphp
                                    <span class="bg-blue">{{ $log->created_at->translatedFormat('l\, j \de F \de Y') }}</span>
                                </div>


                                <div>
                                    <i class="fas fa-bullhorn bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $log->created_at->diffForHumans() }}</span>
                                        <h3 class="timeline-header"><a href="#">{{ $log->user->name }}</a> {{ $log->action }}</h3>
                                    </div>
                                </div>

                            @endforeach



                            {{--                    <div>--}}
                            {{--                        <i class="fas fa-user bg-green"></i>--}}
                            {{--                        <div class="timeline-item">--}}
                            {{--                            <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>--}}
                            {{--                            <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}

                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
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

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();

            //btn waiting
            $('#btn_submit').click(function() {
                $(this).hide();
                $('#btn_waiting').show();
            });

        });
    </script>

@stop

