<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>{{ config('adminlte.title') }}</title>
    <!-- MDB icon -->
    {{-- favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('pag_index/fontawesome/css/all.min.css') }}" />
    <!-- Google Fonts Roboto -->
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
    />
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('pag_index/css/mdb.min.css') }}" />
</head>
<body>
<!-- Start your project here-->

<!--Main Navigation-->
<header>
    <style>
        /* Carousel styling */
        #introCarousel,
        .carousel-inner,
        .carousel-item,
        .carousel-item.active {
            height: 100vh;
        }

        .carousel-item:nth-child(1) {
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }

        .carousel-item:nth-child(2) {
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }

        .carousel-item:nth-child(3) {
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }

        /* Height for devices larger than 576px */
        @media (min-width: 992px) {
            #introCarousel {
                margin-top: -58.59px;
            }
        }

        .navbar .nav-link {
            color: #fff !important;
        }
    </style>

    <!-- Navbar -->
    <nav
        class="navbar navbar-expand-lg navbar-dark d-none d-lg-block"
        style="z-index: 2000"
    >
        <div class="container-fluid">
            <!-- Navbar brand -->
            <a class="navbar-brand nav-link" href="{{ route('publications.show', $publication->id) }}">
                <strong>VOLTAR</strong>
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-mdb-toggle="collapse"
                data-mdb-target="#navbarExample01"
                aria-controls="navbarExample01"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>

        </div>
    </nav>
    <!-- Navbar -->

    <!-- Carousel wrapper -->
    <div
        id="introCarousel"
        class="carousel slide carousel-fade shadow-2-strong"
        data-mdb-ride="carousel"
    >
        <!-- Indicators -->
        <ol class="carousel-indicators">
                <li data-mdb-target="#introCarousel" data-mdb-slide-to="0" class="active"></li>
        </ol>

        <!-- Inner -->
        <div class="carousel-inner">

                {{--item com imagem--}}
                <div class="carousel-item active" data-mdb-interval="10000">

                    @if($publication->tipo == 'imagem')
                        <img src="{{ asset('publish/tv/' . $publication->imagem ) }}" class="d-block w-100 h-100" alt="Wild Landscape"/>

                    @elseif($publication->tipo == 'video')
                                    <!-- Single item -->

                        <video
                            style="min-width: 100%; min-height: 100%"
                            playsinline
                            autoplay
                            muted
                            loop
                        >
                            <source
                                class="h-100"
                                src="{{ asset('publish/tv/' . $publication->imagem ) }}"
                                type="video/mp4"
                            />
                        </video>

                    @elseif($publication->tipo == 'texto')

                    <img src="{{ asset('publish/tv/modelo4.png' ) }}" class="d-block w-100 h-100" alt="Wild Landscape"/>
                    <div class="mask" style="background-color: rgba(0, 0, 0, 0.4)">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="text-white text-center">
                                <h1>{{ $publication->titulo }}</h1>

                                <div class="card justify-content-center w-100 h-100 text-black">
                                    <div class="card-body">
                                        <h3>{!! $publication->texto !!}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif

                </div>



        </div>
        <!-- Inner -->

        <!-- Controls -->
        <a class="carousel-control-prev" href="#introCarousel" role="button" data-mdb-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#introCarousel" role="button" data-mdb-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- Carousel wrapper -->
</header>
<!--Main Navigation-->


<!-- End your project here-->

<!-- MDB -->
<script type="text/javascript" src="{{ asset('pag_index/js/mdb.min.js') }}"></script>
<!-- Custom scripts -->
<script type="text/javascript"></script>
</body>
</html>
