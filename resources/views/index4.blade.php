<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>IFG.TV</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        #clock {
            position: fixed;
            bottom: 1px;
            right: 1px;
            background: rgba(26, 34, 56, 0.85);  /* #1a2238 com 85% de opacidade */
            color: #ffffff;
            padding: 15px 25px;
            border-radius: 8px;
            font-family: 'Digital-7', monospace;
            z-index: 1000;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        #clock .time {
            font-size: 38px;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        #clock .date {
            font-size: 16px;
            font-family: Arial, sans-serif;
            color: #ffffff;
            letter-spacing: 1px;
        }

        @font-face {
            font-family: 'Digital-7';
            src: url('{{ asset("fonts/digital-7.ttf") }}') format('truetype');
        }

        #main {
            width: 1280px;
            height: 680px;
            background: #F0F0F0;
            padding-top: 40px;
            overflow: hidden;
        }

        #news-panel {
            width: 1200px;
            height: 590px;
            box-shadow: 0px 5px 5px black;
            margin: 0 auto;
        }

        #pagination {
            display: block;
            text-align: center;
            margin: 20px auto;
        }

        #pagination li {
            display: inline-block;
            border: 5px solid #4D4D4D;
            border-radius: 50%;
            width: 43px;
            height: 43px;
            line-height: 43px;
            font-size: 20pt;
            font-weight: bold;
            color: #4D4D4D;
            box-shadow: 0px 3px 6px black;
            margin-left: 20px;
        }

        #pagination .first {
            margin-left: 0;
        }

        #pagination .selected {
            background: #B3B3B3;
        }

        #news-panel .image-news, #news-panel .textual-news {
            width: 1200px;
            height: 590px;
            display: none;

        }

        #news-panel .visible {
            display: block;
        }

        {{--.textual-news {--}}
        {{--    background:url("{{ asset('publish/tv/5.png')  }}");--}}
        {{--    width: 100%;--}}
        {{--    height: 100%;--}}

        {{--}--}}

        .textual-news .title {
            font-size: 33pt;
            color: #4D4D4D;
            font-weight: bold;
            margin-bottom: 40px;
            padding-top: 84px;
        }

        .textual-news .container {
            overflow: hidden;
        }


        .textual-news .text {
            font-size: 20pt;
            margin-left: 40px;
            margin-right: 40px;
        }
{{--        @if($publication->imagem == 'aniversario')--}}
{{--        .textual-news .text {--}}
{{--            font-size: 30pt;--}}
{{--            margin-left: 40px;--}}
{{--            margin-right: 40px;--}}
{{--        }--}}
{{--        @else--}}
{{--        .textual-news .text {--}}
{{--            font-size: 20pt;--}}
{{--            margin-left: 40px;--}}
{{--            margin-right: 40px;--}}
{{--        }--}}
{{--        @endif--}}

    </style>
</head>
<body>
<div id="clock">
    <div class="time"></div>
    <div class="date"></div>
</div>
<div id="main">
    <div id="news-panel">

        @forelse($publications as $publication)
            @if($publication->tipo === 'imagem')
                <img class="image-news" src="{{ asset('publish/tv/' . $publication->imagem)  }} " />
            @elseif($publication->tipo === 'texto')

                @if($publication->imagem == 'preto')
                    <div class="textual-news" style="background-image: url('{{ asset('publish/tv/1.png')  }}'); width: 100%; height: 100%">
                @elseif($publication->imagem == 'verde')
                    <div class="textual-news" style="background-image: url('{{ asset('publish/tv/2.png')  }}'); width: 100%; height: 100%">
                @elseif($publication->imagem == 'turquesa')
                    <div class="textual-news" style="background-image: url('{{ asset('publish/tv/3.png')  }}'); width: 100%; height: 100%">
                @elseif($publication->imagem == 'cinza')
                    <div class="textual-news" style="background-image: url('{{ asset('publish/tv/4.png')  }}'); width: 100%; height: 100%">
                @elseif($publication->imagem == 'amarelo')
                    <div class="textual-news" style="background-image: url('{{ asset('publish/tv/5.png')  }}'); width: 100%; height: 100%">
                @elseif($publication->imagem == 'roxo')
                    <div class="textual-news" style="background-image: url('{{ asset('publish/tv/6.png')  }}'); width: 100%; height: 100%">
                @elseif($publication->imagem == 'aniversario')
                    <div class="textual-news" style="background-image: url('{{ asset('publish/tv/7.png')  }}'); width: 100%; height: 100%">
                @else
                    <div class="textual-news" style="background-image: url('{{ asset('publish/tv/2.png')  }}'); width: 100%; height: 100%">
                @endif

                        <div class="container">
                            <div class="text">

                                @if($publication->imagem == 'aniversario')

                                    <div class="title" style="font-size: 50px">
                                        <p style="text-align: center">
                                        {!! $publication->titulo !!}
                                        </p>
                                    </div>

                                @else
                                    <div class="title">{!! $publication->titulo !!}</div>
                                @endif


                                <div class="text" style="font-size: 40px">{!! $publication->texto !!}</div>
                            </div>
                        </div>
                    </div>
                @endif

                @empty
{{--                    imagem normal de quando não tiver publicações--}}
                        <img class="image-news" src="{{ asset('publish/tv/0.png' ) }}" />
                @endforelse

    </div>
    <ul id="pagination"><!-- pagination goes here --></ul>
</div>
<script>
    // Função para atualizar o relógio
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';

        // Array com os nomes dos dias da semana
        const weekDays = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

        // Array com os nomes dos meses
        const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                       'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        // Formatando a data
        const dayName = weekDays[now.getDay()];
        const day = String(now.getDate()).padStart(2, '0');
        const month = months[now.getMonth()];
        const year = now.getFullYear();

        // Atualizando o relógio
        document.querySelector('#clock .time').textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
        document.querySelector('#clock .date').textContent = `${dayName}, ${day} ${month} ${year}`;
    }

    // Atualiza o relógio a cada segundo
    updateClock();
    setInterval(updateClock, 1000);

    // Configurações
    var secondsPerPage = {{ $config->slide_time }}; // tempo em segundos para cada página
    var pages = $("news-panel").children.length;


    // Função básica de seleção de elementos por ID
    function $ (elementId) {
        return document.getElementById(elementId);
    }

    // Inicialização dos elementos tratados como notícias/páginas
    for (var i = 0; i < pages; i++)
        $("news-panel").children[i].id = "news-" + (i + 1)


    // Paginação
    for (var i = 1; i <= pages; i++)
        $("pagination").innerHTML += "<li id=\"pg-" + i + "\" onclick=\"showNews(" + i + ")\">" + i + "</li>\n";

    // Função que exibe uma notícia. Substitui a notícia corrente pela notícia especificada
    function showNews(number) {
        var newsPanel = $('news-panel');
        newsPanel.getElementsByClassName('visible')[0].classList.remove('visible');
        $('news-' + number).classList.add('visible');

        var pagination = $('pagination');
        pagination.getElementsByClassName('selected')[0].classList.remove('selected');
        $("pg-" + number).classList.add('selected');
    }

    // Troca automática de notícias (páginas)
    var counter = 0;
    function change() {
        counter++;
        if (counter > pages){
            location.reload(true);
        }else{
            showNews(counter);
        }
    }

    if (pages > 0) {
        $("pg-1").className = "first selected";
        $("news-1").classList.add("visible");
        setInterval(change, secondsPerPage * 1000);
    }

//    var vid = document.getElementById("myVideo");
//     vid.autoplay = true;
//     vid.load();
</script>
</body>
</html>
