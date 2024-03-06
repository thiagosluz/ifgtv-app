@extends('adminlte::page')

@section('title', 'Resultado do Relatório')

@section('content_header')
    <h1>Resultado do Relatório</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <strong>Relatório de Publicações</strong><br>
                            {!! $report_type === 'individual' ? '<strong>Nome: </strong>' . auth()->user()->name : '<strong>Setor: </strong>' . auth()->user()->setor->nome  !!}
                            <br>
                            <strong>Data Inicial:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $start_date)->format('d/m/Y') }} - <strong>Data Final:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $end_date)->format('d/m/Y') }}
                            <br>
                        </h5>

                        <!-- Adicione este botão no seu arquivo blade -->
                        <button class="btn btn-primary btn-flat float-right no-print" onclick="window.print()">
                            <i class="fas fa-print"></i>
                            Imprimir
                        </button>
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-flat float-right no-print" style="margin-right: 5px;">
                            <i class="fas fa-arrow-left"></i>
                            Voltar
                        </a>

                    </div>
                    <div class="card-body table-responsive">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Mês</th>
                                    <th>Ano</th>
                                    <th>Total de Publicações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($publications as $publication)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::createFromDate($publication->year, $publication->month)->translatedFormat('F') }}</td>
                                        <td>{{ $publication->year }}</td>
                                        <td>{{ $publication->total }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Gráfico do Relatório
                        </h3>

                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>



@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($publications->pluck('month_year')) !!},
                datasets: [{
                    label: 'Total de Publicações por Mês',
                    data: {!! json_encode($publications->pluck('total')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection

@section('adminlte_css')

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>


@endsection

@section('footer')
    {{ config('adminlte.title') }} &copy; @php(print date('Y'))
@stop
