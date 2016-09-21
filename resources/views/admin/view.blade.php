@extends('layout.master')

@section('content')
    @if($user->validado)
        <div class="alert alert-success">
            <strong>Conta ativada!</strong>
        </div>
    @else
        <div class="alert alert-warning">
            <strong>Essa conta ainda não foi ativada!</strong>
        </div>
    @endif
    <ul class="list-unstyled">
        <li><strong>Nome: </strong>{{ $user->nome }}</li>
        <li><strong>Email: </strong>{{ $user->email }}</li>
        <li><strong>Telefone 1: </strong>{{ $user->telefone or '-' }}</li>
        <li><strong>Telefone 2: </strong>{{ $user->telefone2 or '-' }}</li>
        <li><strong>Endereço: </strong>{{ $user->endereco or '-' }}</li>
        <li><strong>CEP: </strong>{{ $user->cep or '-' }}</li>
        <li><strong>Data de Nascimento: </strong>{{ $user->nascimento or '-' }}</li>
        <li><strong>Categoria: </strong>{{ $user->categoria or '-' }}</li>
        <li><strong>Escola: </strong>{{ $user->escola or '-' }}</li>
        <li><strong>Série: </strong>{{ $user->serie or '-' }}</li>
    </ul>
@endsection