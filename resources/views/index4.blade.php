
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
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

    </style>
</head>
<body>
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
                @else
                    <div class="textual-news" style="background-image: url('{{ asset('publish/tv/2.png')  }}'); width: 100%; height: 100%">
                @endif

                        <div class="container">
                            <div class="text">
                                <div class="title">{{ $publication->titulo }}</div>
                                <div class="text">{!! $publication->texto !!}</div>
                            </div>
                        </div>
                    </div>
                @endif

                @empty

                @endforelse

    </div>
    <ul id="pagination"><!-- pagination goes here --></ul>
</div>
<script>

    // Configurações
    var secondsPerPage = 30; // tempo em segundos para cada página
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
</script>
</body>
</html>
