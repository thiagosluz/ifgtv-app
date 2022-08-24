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

    <h5 class="mb-2">Publicações</h5>

    <div class="row">

        <div class="col-lg-3 col-6">

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

        <div class="col-lg-3 col-6">

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

    </div>

@stop

@section('footer')
      {{ config('adminlte.title') }} &copy; @php(print date('Y'))
@stop

@section('adminlte_css')

{{--    <link rel="stylesheet" type="text/css"--}}
{{--          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>--}}

@stop

