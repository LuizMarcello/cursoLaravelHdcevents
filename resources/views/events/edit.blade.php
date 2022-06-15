@extends('layouts.main')

@section('title', 'Editando o evento: ' . $evennnt->title)

@section('content')

    <div id="event-create-container" class="col-md-6 offset-md-3">
        <h2>Editando: {{ $evennnt->title }}</h2>
        <form action="/events/update/{{ $evennnt->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="image">Imagem do evento:</label>
                <input type="file" id="image" name="image" class="form-control-file">
                <img src="/img/events/{{ $evennnt->image }}" alt="{{ $evennnt->title }}" class="img-preview">
            </div>
            <div class="form-group">
                <label for="title">Evento:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nome do evento"
                    value="{{ $evennnt->title }}">
            </div>
            <div class="form-group">
                <label for="date">Data do evento:</label>
                <input type="date" class="form-control" id="date" name="date"
                    value="{{ $evennnt->date->format('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label for="title">Cidade:</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Local do evento"
                    value="{{ $evennnt->city }}">
            </div>
            <div class="form-group">
                <label for="title">O evento é privado?</label>
                <select name="private" id="private" class="form-control">
                    <option value="0">Não</option>
                    <option value="1" {{ $evennnt->private == 1 ? "selected='selected'" : '' }}>Sim</option>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Descrição:</label>
                <textarea name="description" id="description" class="form-control" placeholder="Acontecimento no evento">
                {{ $evennnt->description }}
                </textarea>
            </div>

            <div class="form-group">
                <label for="title">Adicione itens de infraestrutura:</label>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cadeiras"> Cadeiras
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Palco"> Palco
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cerveja Grátis"> Cerveja grátis
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open Food"> Open food
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Brindes"> Brindes
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Editar Evento">
        </form>
    </div>

@endsection
