@extends('layout.master')

@section('content')
    <table class="table table-hover">
        <thead>
        <tr>
            <th class="text-center">Nome</th>
            <th class="text-center">Email</th>
            <th class="text-center" width="100">Ações</th>
        </tr>
        </thead>
        <tbody>

        @foreach($users as $pessoa)
        <tr>
            <td>{{ $pessoa['cn'][0] }}</td>
            <td>{{ $pessoa['uid'][0] }}</td>
            <td>
                <a href="/admin/view/{{ $pessoa['uid'][0] }}"><img src="/img/view.png" alt="" width="24"></a>
                <a href="/admin/delete/{{ $pessoa['uid'][0] }}"><img src="/img/delete.png" alt="" width="24"></a>

            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection