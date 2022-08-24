@component('mail::message')
# Dados da Publicação

<p>Autor: {{ $publication->user->name }}</p>
<p>Título: {{ $publication->titulo }}</p>
<p>Tipo: {{ $publication->tipo }}</p>

@if($publication->publicado == 0)
@component('mail::button', ['url' => $url])
Aprovar publicação
@endcomponent
@endif

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
