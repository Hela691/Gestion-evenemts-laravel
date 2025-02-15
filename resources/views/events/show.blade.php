<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'événement</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-r from-purple-600 to-blue-500 min-h-screen flex items-center justify-center p-6">

    <!-- Conteneur principal de l'événement -->
    <div class="w-full max-w-2xl bg-white/90 backdrop-blur-sm rounded-lg shadow-xl p-6 space-y-4">
        
        <!-- En-tête de l'événement -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800">{{ $event->name }}</h1>
        </div>

        <!-- Détails de l'événement -->
        <div class="space-y-4">
            <div class="bg-gray-50 rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold text-gray-800">Description</h3>
                <p class="text-gray-600 text-sm">{{ $event->description ?? 'Aucune description fournie.' }}</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold text-gray-800">Date de l'événement</h3>
                <p class="text-gray-600 text-sm">
                    {{ \Carbon\Carbon::parse($event->event_date)->locale('fr')->translatedFormat('d F Y') }}
                </p>
            </div>

            <div class="bg-gray-50 rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold text-gray-800">Capacité</h3>
                <p class="text-gray-600 text-sm">{{ $event->capacity }} personnes</p>
                <p class="text-gray-500 text-xs">Participants : {{ $event->users->count() }}</p>
            </div>
        </div>

        <!-- Section d'interaction -->
        <div class="bg-gray-50 p-4 text-center rounded-lg space-y-3">
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @php
                $isParticipating = $event->users->contains(Auth::user());
                $isEventPassed = $event->event_date < now();
                $isCapacityReached = $event->users->count() >= $event->capacity;
            @endphp

            @if(Auth::check())
                @if ($isEventPassed)
                    <p class="text-sm font-semibold text-red-600">Événement terminé.</p>
                @elseif ($isParticipating)
                    <p class="text-sm font-semibold text-green-600">Vous participez déjà.</p>
                @elseif ($isCapacityReached)
                    <p class="text-sm font-semibold text-red-600">Capacité atteinte.</p>
                @else
                    <form action="{{ route('events.participate', $event->id) }}" method="POST">
                        @csrf
                        <button class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600">
                            Participer
                        </button>
                    </form>
                @endif
            @else
                <p class="text-sm text-gray-600">Connectez-vous pour participer.</p>
            @endif
            
            <a href="{{ route('events.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                Retour
            </a>
        </div>
    </div>

</body>
</html>
