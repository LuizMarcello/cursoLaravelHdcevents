@extends('layouts.main')

@section('title', $eventtt->title)

@section('content')

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                {{-- class="img-fluid": Para deixar a imagem responsiva --}}
                <img src="/img/events/{{ $eventtt->image }}" class="img-fluid" alt="{{ $eventtt->title }}">
            </div>
            <div id="info-container" class="col-md-6">
                <h3>{{ $eventtt->title }}</h3>
                <p class="event-city">
                    <ion-icon name="location-outline"></ion-icon>{{ $eventtt->city }}
                </p>
                <p class="events-participants">
                    <ion-icon name="people-outline"></ion-icon>X Participantes
                </p>
                <p class="event-owner">
                    <ion-icon name="star-outline"></ion-icon>Dono do evento
                </p>
                <a href="#" class="btn btn-primary" id="event-submit">Confirmar presença</a>
                <h3>O evento conta com:</h3>
                <ul id="items-list">
                    @foreach ($eventtt->items as $item)
                        <li>
                            <ion-icon name="play-outline"></ion-icon> <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12" id="description-container">
                <h3>Sobre o evento:</h3>
                <p class="event-description">{{ $eventtt->description }}</p>
            </div>
        </div>
    </div>

@endsection
