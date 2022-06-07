@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')

    <h1>Algum título</h1>
    <img src="/img/banner.jpg" alt="Banner">
    @if (10 > 5)
        <p>A condição é true</p>
    @endif

    <p>{{ $nomee }}</p>

    @if ($nomee == 'Pedro')
        <p>O nome é Pedro</p>
    @elseif($nomee == 'LuizMarcello')
        <p>O nome é {{ $nomee }} e idade de {{ $idadee }} anos, e trabalha como
             {{ $profissaoo }}</p>
    @else
        <p>O nome não é pedro</p>
    @endif

    @for ($i = 0; $i < count($arrrr); $i++)
        <p>{{ $arrrr[$i] }} - {{ $i }}</p>
        @if ($i == 2)
            <p>Nesse ponto o i é igual a 2</p>
        @endif
    @endfor

    {{-- Aqui dentro será código PHP puro normal --}}
    {{-- É possível então PHP puro no Blader --}}
    @php
    $name = 'João';
    echo $name;
    @endphp

    {{-- Comentários com o blade deve ser assim --}}
    {{-- Não aparece na view e nem é renderizado, sem perigo --}}
    @foreach ($nomess as $nome)
        <p>{{ $loop->index }}</p>
        <p>{{ $nome }}</p>
    @endforeach

@endsection
