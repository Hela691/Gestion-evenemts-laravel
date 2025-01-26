<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total des événements
        $totalEvents = Event::count();

        // Total des utilisateurs ayant participé à un événement
        $totalParticipants = DB::table('event_user')->distinct('user_id')->count('user_id');

        // Nombre d'événements à venir
        $upcomingEvents = Event::where('event_date', '>', now())->count();

        // Nombre moyen de participants par événement en utilisant la jointure avec 'event_user'
        $averageParticipants = Event::join('event_user', 'events.id', '=', 'event_user.event_id')
            ->select(DB::raw('count(DISTINCT event_user.user_id) as participants_count'))
            ->groupBy('events.id')  // 'events.id' au lieu de 'event_id'
            ->get()
            ->avg('participants_count');

        // Passer les données à la vue
        return view('dashboard.index', compact(
            'totalEvents', 'totalParticipants', 'upcomingEvents', 'averageParticipants'
        ));
    }
}
