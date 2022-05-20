@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')



@stop

@section('footer')
      {{ config('adminlte.title') }} &copy; @php(print date('Y'))
@stop

@section('adminlte_css')

{{--    <link rel="stylesheet" type="text/css"--}}
{{--          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}

@stop

@section('js')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>--}}
@stop

