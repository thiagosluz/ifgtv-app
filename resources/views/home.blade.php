@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard</h1>
        </div>
    </div>
@stop

@section('content')

    @hasanyrole('Super-Admin|admin|moderador|usuario')

        <h5 class="mb-2">Publicações</h5>

        <div class="row">

            <div class="col-lg-4 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $publicados }}</h3>
                        <p>Publicações nas TVs</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-monitor"></i>
                    </div>
                    <a href="{{ route('publications.index') }}" class="small-box-footer">
                        Mais info. <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $aguardando }}</h3>
                        <p>Esperando Aprovação</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <a href="{{ route('publications.index') }}" class="small-box-footer">
                        Mais info. <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


            @hasanyrole('Super-Admin|admin')
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $users_without_any_roles }}</h3>
                            <p>Usuários Aguardando Cadastro</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('users.index') }}" class="small-box-footer">
                            Mais info.
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasanyrole

        </div>

        <div class="row ">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Grafico de postagens no ano de {{ Carbon\Carbon::now()->format('Y') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="100px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-info"></i> Bem-vind@ ao IFG.TV</h5>
            Seu cadastro precisa de aprovação de um administrador, aguarde.
        </div>

    @endhasanyrole



@stop

@section('footer')
    {{ config('adminlte.title') }} &copy; @php(print date('Y'))
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
    @include('layouts.erros_toast')

    <script type="text/javascript">
        var labels = {{ Js::from($labels) }};
        var users = {{ Js::from($data) }};

        const data = {
            labels: labels,
            datasets: [{
                label: 'Quantidade de publicações no mês',
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgba(153, 102, 255)',
                    'rgba(201, 203, 207)',
                    'rgba(255, 159, 64)',
                    'rgba(75, 192, 192)',
                    'rgba(54, 162, 235)',
                    'rgba(200, 162, 235)',
                    'rgba(100, 12, 35)',
                    'rgba(134, 132, 5)',
                    'rgba(24, 92, 75)',
                ],
                hoverOffset: 4,
                data: users,
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
@stop
