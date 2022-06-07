@extends('layouts.main')

@section('title', 'Produtos')

@section('content')
    <h1>Tela de produtos</h1>
    @if ($buscaa != '')
        <p>O usuário está buscando por: {{ $buscaa }}</p>
    @endif
@endsection
