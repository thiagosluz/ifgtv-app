@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div id="carouselExampleControls" class="carousel slide carousel-fade" data-bs-ride="carousel">

{{--            carousel-indicators --}}
            <ol class="carousel-indicators my-4">
                @forelse($publications as $publication)
                    <li data-bs-target="#carouselExampleControls" aria-label="test {{ $loop->index }}" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @empty
                    <li data-bs-target="#carouselExampleControls" data-bs-slide-to="0" class="active"></li>
                @endforelse
            </ol>

            <div class="carousel-inner">
                @forelse($publications as $publication)
                    @if($publication->tipo === 'imagem')
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="{{ $config->slide_time * 1000 }}">
                            <img src="{{ asset('publish/tv/' . $publication->imagem)  }} " class="d-block w-100" alt="...">
                        </div>
                    @elseif($publication->tipo === 'texto')

                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="{{ $config->slide_time * 1000 }}">

                            @if($publication->imagem == 'preto')
                                <img src="{{ asset('publish/tv/1.png' ) }}" class="d-block w-100" alt="...">
                            @elseif($publication->imagem == 'verde')
                                <img src="{{ asset('publish/tv/2.png' ) }}" class="d-block w-100" alt="...">
                            @elseif($publication->imagem == 'turquesa')
                                <img src="{{ asset('publish/tv/3.png' ) }}" class="d-block w-100" alt="...">
                            @elseif($publication->imagem == 'cinza')
                                <img src="{{ asset('publish/tv/4.png' ) }}" class="d-block w-100" alt="...">
                            @elseif($publication->imagem == 'amarelo')
                                <img src="{{ asset('publish/tv/5.png' ) }}" class="d-block w-100" alt="...">
                            @elseif($publication->imagem == 'roxo')
                                <img src="{{ asset('publish/tv/6.png' ) }}" class="d-block w-100" alt="...">
                            @elseif($publication->imagem == 'aniversario')
                                <img src="{{ asset('publish/tv/7.png' ) }}" class="d-block w-100" alt="...">
                            @else
                                <img src="{{ asset('publish/tv/2.png' ) }}" class="d-block w-100" alt="...">
                            @endif



                            <div class="carousel-caption d-none d-md-block">
{{--                                <h1>{{ $publication->titulo }}</h1>--}}
                                @if($publication->imagem == 'aniversario')

                                    <div style="font-size: 50px">
                                            {!! $publication->titulo !!}
                                    </div>

                                @else
                                    <h1>{!! $publication->titulo !!}</h1>
                                @endif
                                <div style="font-size: 2em; text-align: left;">{!! $publication->texto !!}</div>
                            </div>
                        </div>

                    @endif
                @empty
                    <div class="carousel-item active">
                        <img src="{{ asset('publish/tv/0.png' ) }}" class="d-block w-100" alt="...">
                        {{--                            <div class="carousel-caption d-none d-md-block">--}}
                        {{--                                <h1>Título da Imagem 1</h1>--}}
                        {{--                                <p style="font-size: 2em">Descrição ou texto associado à imagem 1.</p>--}}
                        {{--                            </div>--}}
                    </div>
                    {{--                    imagem normal de quando não tiver publicações--}}
                @endforelse


            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let carousel = document.getElementById('carouselExampleControls');

            carousel.addEventListener('slid.bs.carousel', function(event) {
                let activeItemIndex = Array.from(carousel.querySelectorAll('.carousel-item')).findIndex(item => item.classList.contains('active'));

                if (activeItemIndex === 0) {
                    // Carrossel retornou ao primeiro item
                    // Atualize a página
                    location.reload();
                }
            });
        });
    </script>



@endsection
