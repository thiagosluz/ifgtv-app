@extends('adminlte::page')

@section('title', 'Configurações')

@section('content_header')
    <h1>Configurações</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Configurações gerais do IFG.TV</h3>
{{--                    <div class="card-tools">--}}
{{--                        <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
{{--                            <i class="fas fa-minus"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
                </div>

                <div class="card-body">

                    <form action="{{ route('config.update', $config->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        {{--            mostrar campo de tempo de slides--}}
                        <div class="row col-md-3">
                            <div class="form-group">
                                <label for="tempo">Tempo de slides <small class="form-text text-muted">Tempo em segundos</small></label>

                                <input type="number" name="tempo" id="tempo" class="form-control" value="{{ $config->slide_time }}">
                            </div>
                        </div>

                        {{--             campo de frases padrão de aniversário --}}
                        <div class="form-group">
                            <label for="frase">Frase padrão de aniversário</label>
                            <input type="text" name="frase" id="frase" class="form-control" value="{{ $config->birthday_message }}">
                            <p><small class="caracteres"></small></p>
                        </div>

                        <div class="form-group">
{{--                            <button type="submit" class="btn btn-success">Atualizar</button>--}}

                            <button id="btn_submit" type="submit" class="btn btn-success float-right">Atualizar</button>
                            {{-- btn waiting --}}
                            <button type="button" class="btn btn-success float-right" id="btn_waiting" style="display: none">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Salvando...
                            </button>

                        </div>

                    </form>

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
        $(document).ready(function () {

            $(document).on("input", "#frase", function() {
                var limite = 100;
                var informativo = "caracteres restantes.";
                var caracteresDigitados = $(this).val().length;
                var caracteresRestantes = limite - caracteresDigitados;

                if (caracteresRestantes <= 0) {
                    var comentario = $("input[name=frase]").val();
                    $("input[name=frase]").val(comentario.substr(0, limite));
                    $(".caracteres").text("0 " + informativo);
                } else {
                    $(".caracteres").text(caracteresRestantes + " " + informativo);
                }
            });

            $('#btn_submit').click(function () {
                $('#btn_submit').hide();
                $('#btn_waiting').show();
            });
        });
    </script>
@stop

