@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
    <h1>Relatórios</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Gerar Relatórios</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reports.generate') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Selecione o tipo de relatório:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="report_type" id="report_for_user" value="individual" checked>
                                    <label class="form-check-label" for="report_for_user">
                                        Individual
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="report_type" id="report_for_sector" value="setor">
                                    <label class="form-check-label" for="report_for_sector">
                                        Setor
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="start_date">Data Inicial:</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-01-01') }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="end_date">Data Final:</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-flat float-right">Gerar Relatório</button>
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
