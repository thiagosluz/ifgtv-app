@extends('adminlte::page')

@section('title', 'Editar publicação')

@section('content_header')
    <h1>Editar publicação</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                @include('layouts.erros_callout')

                <form action="{{ route('publications.update', $publication->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Editar publicação</h3>
                        </div>
                        <div class="card-body">

                            {{-- Título --}}
                            <div class="form-group">
                                <label for="name">Título</label>
                                <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" placeholder="Título da publicação" value="{{ $publication->titulo }}">
                                @error('titulo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

{{--                            --}}{{-- Tipo --}}
{{--                            <div class="form-group">--}}
{{--                                <label for="name">Tipo</label>--}}
{{--                                <select required="required" id="tipo" name="tipo" class="form-control @error('tipo') is-invalid @enderror">--}}
{{--                                    <option value="">Selecione o tipo</option>--}}
{{--                                    <option value="imagem" {{ old('tipo') == 'imagem' ? 'selected' : '' }}>Imagem</option>--}}
{{--                                    <option value="texto" {{ old('tipo') == 'texto' ? 'selected' : '' }}>Texto</option>--}}
{{--                                    <option value="video" {{ old('tipo') == 'video' ? 'selected' : '' }}>Vídeo</option>--}}
{{--                                </select>--}}
{{--                                @error('tipo')--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $message }}--}}
{{--                                </div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

                            @if($publication->tipo == 'texto')
                            {{-- Descrição --}}
                            <div class="form-group" id="div_descricao">
                                <label for="name">Descrição</label>
                                <textarea name="texto" class="summernote form-control @error('texto') is-invalid @enderror" placeholder="Descrição da publicação">{!! $publication->texto !!}</textarea>
                                @error('texto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @endif

                            @if($publication->tipo == 'imagem')
                            {{-- Imagem --}}
                            <div class="form-group" id="div_imagem">
                                <label for="name">Imagem</label>
                                <input type="file" name="imagem" class="form-control @error('imagem') is-invalid @enderror" placeholder="Imagem da publicação">
                                @error('imagem')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @endif

                            @if($publication->tipo == 'video')
                            {{-- Upload video --}}
                            <div class="form-group" id="div_video">
                                <label for="name">Upload de vídeo</label>
                                <input type="file" name="video" class="form-control @error('video') is-invalid @enderror" placeholder="Upload de vídeo">
                                @error('video')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @endif

                            {{-- Link --}}

                            {{-- Data Expiração --}}
                            <div class="form-group col-md-2">
                                <label for="name">Data de expiração</label>
                                <input type="date" name="data_expiracao" class="form-control @error('data_expiracao') is-invalid @enderror" placeholder="Data de expiração" value="{{ is_null($publication->data_expiracao) ? '' : $publication->data_expiracao->format('Y-m-d') }}">
                                @error('data_expiracao')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="card-footer">
                            <button id="btn_submit" type="submit" class="btn btn-success float-right">Atualizar</button>
                            {{-- btn waiting --}}
                            <button type="button" class="btn btn-success float-right" id="btn_waiting" style="display: none">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Salvando...
                            </button>

                            <a href="{{ route('publications.index') }}" class="btn btn-default">Voltar</a>

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
{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
<link href="{{ asset('js/summernote/summernote.min.css') }}" rel="stylesheet">

@stop

@section('js')
{{--    @include('layouts.delete_sweetalert')--}}
{{--    @include('layouts.erros_toast')--}}
<script src="{{ asset('js/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('js/dist_lang_summernote-pt-BR.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {

        //btn waiting
        $('#btn_submit').click(function() {
            $(this).hide();
            $('#btn_waiting').show();
        });

        $('.summernote').summernote({
            lang: 'pt-BR',
            disableDragAndDrop: true,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });

    });
</script>
@stop

