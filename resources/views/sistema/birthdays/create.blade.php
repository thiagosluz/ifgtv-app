@extends('adminlte::page')

@section('title', 'Novo Aniversariante')

@section('content_header')
    <h1>Novo Aniversariante</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                @include('layouts.erros_callout')

                <form action="{{ route('birthdays.store') }}" method="POST">
                    @csrf
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Novo Aniversariante</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nome" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="birthday">Data de aniversário</label>
                                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                            <input type="text" name="birthday" data-target="#datetimepicker1" class="form-control @error('birthday') is-invalid @enderror datetimepicker-input" placeholder="Data de aniversário" value="{{ old('birthday') }}">
                                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            @error('birthday')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right btn-flat">Salvar</button>
                            <a href="{{ route('birthdays.index') }}" class="btn btn-default btn-flat">Voltar</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Importação:</h5>
                    Pode ser feito uma importação de arquivo CSV contendo Nome do aniversariante e a data de aniversário. O modelo pode ser baixado:
                    <a href="{{ route('birthdays.modelo') }}">Download arquivo modelo</a>

                    </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title">Importação de arquivo CSV</h3>
                    </div>


                    <form action="{{ route('birthdays.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="card-body">


                    <div class="form-group">
                    <label for="exampleInputFile">Aquivo CSV</label>
                    <div class="input-group">
                    <div class="custom-file">
                    <input id="input-file" type="file" name="file" class="form-control @error('file') is-invalid @enderror">

                    @error('file')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                    </div>

                    </div>
                    </div>

                    </div>

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-flat">Importar</button>
                    </div>
                    </form>

                    </div>
            </div>
        </div>
    </div>

@stop

@section('footer')
        {{ config('adminlte.title') }} &copy; @php(print date('Y'))
@stop

@section('adminlte_css')
{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
@stop

@section('js')
{{--    @include('layouts.delete_sweetalert')--}}
{{--    @include('layouts.erros_toast')--}}
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/locale/pt-br.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker(
            {
                format: 'L',
                locale: 'pt-br',
                minDate: '2022-01-01',
                daysOfWeekDisabled: [0, 6]
            }
        );
    });
</script>

@stop

