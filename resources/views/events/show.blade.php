<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'événement</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-r from-purple-600 to-blue-500 min-h-screen flex items-center justify-center p-4">

    <!-- Conteneur principal de l'événement -->
    <div class="w-full max-w-4xl bg-white/90 backdrop-blur-sm rounded-xl shadow-2xl p-8 transform transition-all hover:scale-105 duration-300 space-y-6">
        
        <!-- En-tête de l'événement -->
        <div class="text-center py-8">
            <h1 class="text-4xl font-extrabold text-gray-800">{{ $event->name }}</h1>
        </div>

        <!-- Détails de l'événement -->
        <div class="space-y-6">

            <!-- Description -->
            <div class="bg-gray-50 rounded-xl shadow-md p-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Description</h3>
                <p class="text-gray-600 text-lg">{{ $event->description ?? 'Aucune description fournie.' }}</p>
            </div>

            <!-- Date -->
            <div class="bg-gray-50 rounded-xl shadow-md p-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Date de l'événement</h3>
                <p class="text-gray-600 text-lg">
                    {{ \Carbon\Carbon::parse($event->event_date)->locale('fr')->translatedFormat('d F Y') }}
                </p>
            </div>

            <!-- Capacité -->
            <div class="bg-gray-50 rounded-xl shadow-md p-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Capacité maximale</h3>
                <p class="text-gray-600 text-lg">{{ $event->capacity }} personnes</p>
                <p class="text-gray-500 text-sm">Participants actuels : {{ $event->users->count() }}</p>
            </div>
        </div>

        <!-- Section d'interaction -->
        <div class="bg-gray-50 p-6 text-center rounded-b-xl space-y-4">
            @if (session('success'))
                <!-- Message de succès -->
                <div class="bg-green-100 text-green-700 p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <!-- Message d'erreur -->
                <div class="bg-red-100 text-red-700 p-4 rounded-lg">
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
                    <!-- Message si l'événement est passé -->
                    <p class="text-lg font-semibold text-red-600">
                        Cet événement est déjà passé. Participation impossible.
                    </p>
                @elseif ($isParticipating)
                    <!-- Message si l'utilisateur est déjà inscrit -->
                    <p class="text-lg font-semibold text-green-600">Vous participez déjà à cet événement.</p>
                @elseif ($isCapacityReached)
                    <!-- Message si la capacité est atteinte -->
                    <p class="text-lg font-semibold text-red-600">
                        La capacité maximale est atteinte. Vous ne pouvez pas participer.
                    </p>
                @else
                    <!-- Formulaire de participation -->
                    <form action="{{ route('events.participate', $event->id) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:ring-4 focus:ring-green-300 transition duration-300 space-x-3"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-lg font-semibold">Participer</span>
                        </button>
                    </form>
                @endif
            @else
                <!-- Message si l'utilisateur n'est pas connecté -->
                <p class="text-lg text-gray-600">Veuillez vous connecter pour participer à cet événement.</p>
            @endif

            <!-- Bouton de retour -->
            <a 
                href="{{ route('events.index') }}" 
                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-300 space-x-3"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                </svg>
                <span class="text-lg">Retour à la liste</span>
            </a>
        </div>
    </div>

</body>
</html>
