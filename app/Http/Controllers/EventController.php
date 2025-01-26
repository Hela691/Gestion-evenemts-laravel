<?php

namespace App\Http\Controllers;



use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class EventController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth'); // Ajout du middleware pour protéger les routes
    }

    public function index()
    {
        //$events = Event::all(); // Tous les événements
        //$userEvents = Auth::user()->events; // Les événements auxquels l'utilisateur participe

        //return view('events.index', compact('events', 'userEvents'));
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'capacity' => 'required|integer|min:1',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'capacity' => 'required|integer|min:1',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function users()
    {
       return $this->belongsToMany(User::class, 'event_user');
    }

    public function participate($eventId)
    {
        $event = Event::findOrFail($eventId);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Vérification de la date de l'événement
        if ($event->event_date < now()) {
          return redirect()->route('events.show', $eventId)
            ->with('error', 'Vous ne pouvez pas participer à un événement qui est déjà passé.');
        }

        // Vérification de la capacité maximale
        $currentParticipants = $event->users()->count();
        if ($currentParticipants >= $event->capacity) {
          return redirect()->route('events.show', $eventId)
            ->with('error', 'La capacité maximale de participants pour cet événement a été atteinte.');
        }
    
        if ($user->events()->where('event_id', $eventId)->exists()) {
            return redirect()->route('events.show', $eventId)
                ->with('error', 'Vous participez déjà à cet événement.');
        }
    
        $user->events()->attach($eventId);
    
        return redirect()->route('events.show', $eventId)
            ->with('success', 'Vous avez bien rejoint l\'événement.');
    }

public function myEvents()
{
    $user = Auth::user();
    $events = $user->events;  // Récupère tous les événements auxquels l'utilisateur participe
    return view('events.my_events', compact('events'));
}

public function getUserEvents(Request $request)
{
    // Vérifie que l'utilisateur est authentifié
    $user = $request->user();
    
    // Récupère les événements auxquels l'utilisateur participe
    $userEvents = $user->events;

    // Retourne les événements sous forme de JSON
    return response()->json($userEvents);
}







    

}
