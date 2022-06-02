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

        .textual-news {
            padding: 20px;
            width: 1160px !important;
            height: 550px !important;
            background-color: #DFDFDF;
        }

        .textual-news .date {
            font-size: 20pt;
            color: #4D4D4D;
            font-weight: bold;
        }

        .textual-news .title {
            font-size: 33pt;
            color: #4D4D4D;
            font-weight: bold;
            margin-bottom: 23px;
        }

        .textual-news .container {
            overflow: hidden;
        }

        .textual-news p {
            font-size: 20pt;
            color: #4D4D4D;
            text-indent: 133px;
        }

        .textual-news .image {
            width: 426px;
            height: 284px;
        }

        .textual-news .text {
            float: right;
            width: 686px;
        }

        .textual-news .footer {
            margin-top: 20px;
            font-size: 17pt;
            color: #4D4D4D;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
<div id="main">
    <div id="news-panel">
        <img class="image-news" src=" {{ asset('publish/tv/modelo4.png') }} " />
        <img class="image-news" src=" {{ asset('publish/tv/publi_tv_1653667732.png') }} " />
        <img class="image-news" src=" {{ asset('publish/tv/modelo4.png') }} " />

        <video  class="image-news" width="320" height="240" autoplay muted loop>
            <source src="{{ asset('publish/tv/publi_tv_1653667841.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>


    </div>
    <ul id="pagination"><!-- pagination goes here --></ul>
</div>
<script>

    // Configurações
    var secondsPerPage = 30;
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
    var counter = 1;
    function change() {
        counter++;
        if (counter > pages)
            location.reload(true);
        showNews(counter);
    }
    if (pages > 0) {
        $("pg-1").className = "first selected";
        $("news-1").classList.add("visible");
        setInterval(change, secondsPerPage * 1000);
    }
</script>
</body>
</html>
