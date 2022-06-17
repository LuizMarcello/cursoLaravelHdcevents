@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')

    <div id="search-container" class="col-md-12">
        <form action="/" method="GET">
            <input type="text" id="search" name="search" class="form-control" placeholder="Procurar...">
        </form>
    </div>
    <div id="events-container" class="col-md-12">
        @if ($searchh)
            <h3>Buscando por: {{ $searchh }}</h3>
        @else
            <h3>Próximos Eventos</h3>
            <p class="subtitle">Veja os eventos dos próximos dias:</p>
        @endif
        <div id="cards-container" class="row">
            @foreach ($eventts as $event)
                <div class="card col-md-3">
                    <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}">
                    <div class="card-body">
                        {{-- strtotime() é o timestamp --}}
                        <p class="card-date">Em {{ date('d/m/Y', strtotime($event->date)) }}</p>
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-participants"> {{ count($event->users) }} Participante(s) inscrito(s)</p>
                        <a href="/events/{{ $event->id }}" class="btn btn-primary">Saber mais</a>
                    </div>
                </div>
            @endforeach
            @if (count($eventts) == 0 && $searchh)
                <p>Não foi possível encontrar nenhum evento com {{ $searchh }}!
                    <a href="/">Ver todos os eventos</a>
                </p>
            @elseif(count($eventts) == 0)
                <p>Não há eventos disponíveis</p>
            @endif
        </div>
    </div>

@endsection
