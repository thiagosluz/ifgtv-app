@if($errors->any())
    <x-adminlte-callout
        theme="danger"
        title-class="text-danger text-uppercase"
        icon="fas fa-lg fa-exclamation-circle"
        title="Opps, alguma coisa saiu errado">

        <i>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </i>
    </x-adminlte-callout>
@endif
