<?php

/* Os controllers podem retornar uma view ou dar um redirect */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     */

    public function index()
    {
        /* Em 'welcome.blade.php', no 'form', o atributo 'name=search',
        ou seja, se foi enviado alguma pesquisa. */
        $search = request('search');

        if ($search) {
            /* A lógica das buscas */
            $eventss = Event::where([
                ['title', 'like', '%' . $search . '%']
            ])->get();
        } else {
            $eventss = Event::all();
        }

        return view('welcome', ['eventts' => $eventss, 'searchh' => $search]);
    }

    /**
     * Esta 'action' só retorna a view create.blade.php( Formulário )
     *
     * @return void
     */

    public function create()
    {
        return view('events.create');
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

    public function store(Request $request)
    {
        /* Instanciando o model */
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        /* Image upload */
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) .
                '.' . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $event->image = $imageName;
        }

        /* Pegando o id do usuário logado e preenchendo o campo
        'user_id(proprietário do evento)', no banco de dados,
        quando criar um novo evento. */
        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    /**
     * Undocumented function
     *
     * @return void
     */

    public function show($id)
    {
        $event = Event::findOrFail($id);

        /* Pegando o usuário que está autenticado no momento */
        $user = auth()->user();
        $hasUserJoined = false;

        /* Se o usuário está autenticado */
        if ($user) {
            /* Pegando todos os eventos que este usuário participa */
            $userEvents = $user->eventsAsParticipant->toArray();

            foreach ($userEvents as $userEveeent) {
                /* Se o id dos eventos os quais o usuário já participa é
                   igual ao id do evento que vem do request */
                if ($userEveeent['id'] == $id)
                    /* Se for true, então ele já participa deste evento */
                    $hasUserJoined = true;
            }
        }

        /* Usando o 'where()', do 'eloquent orm' */
        /* Pegando o proprietário do evento */
        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        /* Retornando a view "show", junto o evento em questão cfe. id no request,
           também o proprietário do evento, e também os eventos os quais ele já
           participa   */
        return view('events.show', [
            'eventtt' => $event, 'eventOwnerrr' => $eventOwner,
            'hasUserJoiiined' => $hasUserJoined
        ]);
    }

    public function dashboard()
    {
        /* Pegando o usuário que está autenticado no momento */
        $user = auth()->user();

        /* Pegando todos os eventos que este usuário autenticado é proprietário */
        /* Usando a função 'events()' do model User.php */
        $events = $user->events;

        /* Pegando todos os eventos que este usuário participa */
        /* Usando a função "eventsAsParticipant()" do model User.php */
        $eventsAsParticipant = $user->eventsAsParticipant;

        /* Retornando a view, todos os eventos que pertencem a este usuário,
           e tbem todos os eventos os quais ele participa */
        return view('events.dashboard', [
            'eventtts' => $events,
            'eventsAsParticipannnt' => $eventsAsParticipant
        ]);
    }

    public function logoff()
    {
        return view('usuarioLogado');
    }

    /**
     *
     * Deletando o evento
     */

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
    }

    /**
     *
     * Editando o evento
     * Trás a view com o formulário de edição, com os dados a serem alterados.
     */

    public function edit($id)
    {
        /* Pegando o usuário que está autenticado no momento */
        $user = auth()->user();

        $event = Event::findOrFail($id);

        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }

        return view('events.edit', ['evennnt' => $event]);
    }

    /**
     *
     * Persistindo as alterações no bd
     */

    public function update(Request $request)
    {

        $data = $request->all();

        /* Image upload */
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) .
                '.' . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $data['image'] = $imageName;
        }

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
    }

    /**
     * Unindo o usuário ao evento específico
     *
     * @param [type] $id
     * @return void
     */
    public function joinEvent($id)
    {
        /* Pegando o usuário que está autenticado no momento */
        $user = auth()->user();

        /* Unindo(ligando) o usuário autenticado ao evento ID (attach() */
        /* Ligando chave estrangeira */
        $user->eventsAsParticipant()->attach($id);

        /* Localizando o evento no bd */
        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento ' . $event->title);
    }

    /**
     * Não vai mais participar do evento específico
     *
     * @param [type] $id
     * @return void
     */
    public function leaveEvent($id)
    {
        /* Pegando o usuário que está autenticado no momento */
        $user = auth()->user();

        /* Retirando a ligação do usuário autenticado com o evento ID (detach() */
        /* Retirando chave estrangeira */
        $user->eventsAsParticipant()->detach($id);

        /* Localizando o evento no bd, para enviar mensagem */
        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Vocé saiu com sucesso do evento ' . $event->title);
    }
}
