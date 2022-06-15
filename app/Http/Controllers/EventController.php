<?php

/* Os controllers podem retornar uma view ou dar um redirect */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller {
    /**
    * Undocumented function
    *
    * @return void
    */

    public function index() {
        /* Em 'welcome.blade.php', no 'form', o atributo 'name=search',
        ou seja, se foi enviado alguma pesquisa. */
        $search = request( 'search' );

        if ( $search ) {
            /* A lógica das buscas */
            $eventss = Event::where( [
                [ 'title', 'like', '%' . $search . '%' ]
            ] )->get();
        } else {
            $eventss = Event::all();
        }

        return view( 'welcome', [ 'eventts' => $eventss, 'searchh' => $search ] );
    }

    /**
    * Esta 'action' só retorna a view create.blade.php( Formulário )
    *
    * @return void
    */

    public function create() {
        return view( 'events.create' );
    }

    /**
    * Esta 'action' então, após o create(). persiste no bd
    *
    * with(): Para enviar 'flash messages' ou "mensagens
     * por sessão" para a view.
    *
    * @param Request $request
    * @return void
    */

    public function store( Request $request ) {
        /* Instanciando o model */
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        /* Image upload */
        if ( $request->hasFile( 'image' ) && $request->file( 'image' )->isValid() ) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5( $requestImage->getClientOriginalName() . strtotime( 'now' ) ) .
            '.' . $extension;
            $requestImage->move( public_path( 'img/events' ), $imageName );
            $event->image = $imageName;
        }

        /* Pegando o id do usuário logado e preenchendo o campo
        'user_id(proprietário do evento)', no banco de dados,
        quando criar um novo evento. */
        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect( '/' )->with( 'msg', 'Evento criado com sucesso!' );
    }

    /**
    * Undocumented function
    *
    * @return void
    */

    public function show( $id ) {
        $event = Event::findOrFail( $id );

        /* Usando o 'where()', do 'eloquent orm' */
        $eventOwner = User::where( 'id', $event->user_id )->first()->toArray();

        return view( 'events.show', [ 'eventtt' => $event, 'eventOwnerrr' => $eventOwner ] );
    }

    public function dashboard() {
        /* Pegando o usuário que está autenticado no momento */
        $user = auth()->user();

        /* Pegando todos os eventos que este usuário autenticado é proprietário */
        /* Usando a função 'events()' do model User.php */
        $events = $user->events;

        /* Retornando a view, e todos os eventos que pertencem a este usuário */
        return view( 'events.dashboard', [ 'eventtts' => $events ] );
    }

    public function logoff() {
        return view( 'usuarioLogado' );
    }

    /**
    *
    * Deletando o evento
    */

    public function destroy( $id ) {
        Event::findOrFail( $id )->delete();

        return redirect( '/dashboard' )->with( 'msg', 'Evento excluído com sucesso!' );
    }

    /**
    *
    * Editando o evento
    * Trás a view com o formulário de edição, com os dados a serem alterados.
    */

    public function edit ( $id ) {

        $event = Event::findOrFail( $id );

        return view( 'events.edit', [ 'evennnt' => $event ] );
    }

    /**
    *
    * Persistindo as alterações no bd
    */

    public function update ( Request $request ) {

        $data = $request->all();

        /* Image upload */
        if ( $request->hasFile( 'image' ) && $request->file( 'image' )->isValid() ) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5( $requestImage->getClientOriginalName() . strtotime( 'now' ) ) .
            '.' . $extension;
            $requestImage->move( public_path( 'img/events' ), $imageName );
            $data[ 'image' ] = $imageName;
        }

        Event::findOrFail( $request->id )->update( $data );

        return redirect( '/dashboard' )->with( 'msg', 'Evento editado com sucesso!' );
    }

}
