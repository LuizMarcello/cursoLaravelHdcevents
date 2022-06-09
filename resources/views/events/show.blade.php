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
                <h1>{{ $eventtt->title }}</h1>
            </div>
        </div>
    </div>

@endsection
