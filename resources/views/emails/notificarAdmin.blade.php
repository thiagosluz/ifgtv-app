@component('mail::message')
# Um novo usuário se cadastrou no sistema e aguarda definição de permissões.

<p>Usuário: {{ $user->name }}</p>

@component('mail::button', ['url' => $url])
Definir permissões
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
