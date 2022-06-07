@extends('layouts.main')

@section('title', 'Produto')

@section('content')

    @if ($idd != null)
        <p>Exibindo produto id: {{ $idd }}</p>
    @endif
@endsection
