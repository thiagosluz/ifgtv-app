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
            <a class="navbar-brand nav-link" href="{{ route('home') }}">
                <strong>{{ config('adminlte.title') }}</strong>
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
            <li data-mdb-target="#introCarousel" data-mdb-slide-to="1"></li>
            <li data-mdb-target="#introCarousel" data-mdb-slide-to="2"></li>
            <li data-mdb-target="#introCarousel" data-mdb-slide-to="3"></li>
        </ol>

        <!-- Inner -->
        <div class="carousel-inner">
            <!-- Single item -->
            <div class="carousel-item active">
                <video
                    style="min-width: 100%; min-height: 100%"
                    playsinline
                    autoplay
                    muted
                    loop
                >
                    <source
                        class="h-100"
                        src="{{ asset('pag_index/video/teste.mp4') }}"
                        type="video/mp4"
                    />
                </video>
                <div class="mask" style="background-color: rgba(0, 0, 0, 0.6)">
                    <div
                        class="d-flex justify-content-center align-items-center h-100"
                    >
                        <div class="text-white text-center">
                            <h1 class="mb-3">Learn Bootstrap 5 with MDB</h1>
                            <h5 class="mb-4">
                                Best & free guide of responsive web design
                            </h5>
                            <a
                                class="btn btn-outline-light btn-lg m-2"
                                href="https://www.youtube.com/watch?v=c9B4TPnak1A"
                                role="button"
                                rel="nofollow"
                                target="_blank"
                            >Start tutorial</a
                            >
                            <a
                                class="btn btn-outline-light btn-lg m-2"
                                href="https://mdbootstrap.com/docs/standard/"
                                target="_blank"
                                role="button"
                            >Download MDB UI KIT</a
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
                <video
                    style="min-width: 100%; min-height: 100%"
                    playsinline
                    autoplay
                    muted
                    loop
                >
                    <source
                        class="h-100"
                        src="https://mdbootstrap.com/img/video/forest.mp4"
                        type="video/mp4"
                    />
                </video>
                <div class="mask" style="background-color: rgba(0, 0, 0, 0.3)">
                    <div
                        class="d-flex justify-content-center align-items-center h-100"
                    >
                        <div class="text-white text-center">
                            <h2>You can place here any content</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
                <video
                    style="min-width: 100%; min-height: 100%"
                    playsinline
                    autoplay
                    muted
                    loop
                >
                    <source
                        class="h-100"
                        src="https://mdbootstrap.com/img/video/Tropical.mp4"
                        type="video/mp4"
                    />
                </video>
                <div
                    class="mask"
                    style="
                    background: linear-gradient(
                    45deg,
                    rgba(29, 236, 197, 0.7),
                    rgba(91, 14, 214, 0.7) 100%
                    );
                    "
                >
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-white text-center">
                            <h2>And cover it with any mask</h2>
                            <a class="btn btn-outline-light btn-lg m-2" href="https://mdbootstrap.com/docs/standard/content-styles/masks/"
                                target="_blank" role="button">Learn about masks
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item" data-mdb-interval="10000">
                <img src="https://mdbcdn.b-cdn.net/img/new/slides/041.webp" class="d-block w-100 h-100" alt="Wild Landscape"/>

                <div class="mask" style="background-color: rgba(0, 0, 0, 0.6)">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-white text-center">
                            <h2>Título da Noticia</h2>

                            <div class="card justify-content-center w-100 h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text text-black">Some quick example text to
                                        build on the card title and make up the bulk
                                        build on the card title and makeup the bulk
                                        build on the card title and make up the bulk
                                        of the card's content.build on the card title and make up the bulk
                                        build on the card title and makeup the bulk
                                        build on the card title and make up the bulk
                                        of the card's content.build on the card title and make up the bulk
                                        build on the card title and makeup the bulk
                                        build on the card title and make up the bulk
                                        of the card's content.
                                    </p>

                                    <p class="card-text text-black">Some quick example text to
                                        build on the card title and make up the bulk
                                        build on the card title and makeup the bulk
                                        build on the card title and make up the bulk
                                        of the card's content.
                                    </p>
                                    <button type="button" class="btn btn-primary">Button</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



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
