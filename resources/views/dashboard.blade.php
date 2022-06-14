@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h2>Meus eventos</h2>
    </div>
    <div class="col-md-10 offset-md-1 dashboard-events-container">
        @if (count(events) > 0)
        
        @else
            <p>Você ainda não tem eventos, <a href="/events/create">Criar evento</a></p>
        @endif
    </div>

@endsection
