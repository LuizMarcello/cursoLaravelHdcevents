<?php

/* Os controllers podem retornar uma view ou dar um redirect */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller {
    /**
    * Undocumented function
    *
    * @return void
    */

    public function index() {
        $eventss = Event::all();
        return view( 'welcome', [ 'eventts' => $eventss ] );
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
    * Esta 'action' então persiste no bd
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
            $imageName = md5( $requestImage->getClientOriginalName() . strtotime( 'now' ) ) . '.' . $extension;
            $requestImage->move( public_path( 'img/events' ), $imageName );
            $event->image = $imageName;
        }

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

        return view( 'events.show', [ 'eventtt' => $event ] );
    }
}
