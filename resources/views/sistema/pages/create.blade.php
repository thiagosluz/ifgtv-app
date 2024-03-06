@extends('adminlte::page')

@section('title', 'Criar Menu')

@section('content_header')
    <h1>Criar Menu</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <form action="{{ route('pages.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="order">Ordem:</label>
                                <input type="number" name="order" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="text">Texto:</label>
                                <input type="text" name="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="url">URL:</label>
                                <input type="text" name="url" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="icon">Ícone:</label>
                                <input type="text" name="icon" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="can">Permissão:</label>
                                <input type="text" name="can" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary btn-flat float-right">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
