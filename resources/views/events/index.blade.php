<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Événements</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center p-6">

    <!-- Barre de navigation -->
    <nav class="w-full bg-blue-500 p-4 rounded-lg shadow-md mb-6">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">Événements</h1>
            <div class="flex space-x-4">
                <!-- Dashboard Button -->
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    Tableau de bord
                </a>

                <!-- Lien vers le profil -->
                @auth
                    <a href="{{ route('profile') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                        Profil
                    </a>
                @endauth

                <!-- Logout Button -->
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                            Déconnexion
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="w-full max-w-lg bg-green-100 text-green-800 text-center p-4 mt-6 rounded-md shadow-md">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Création d'un événement -->
    @auth
        <div class="w-full max-w-lg text-right mt-6">
            <a href="{{ route('events.create') }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                Créer un événement
            </a>
        </div>
    @endauth

    <!-- Tableau des événements -->
    <div class="w-full max-w-4xl mt-8 bg-white rounded-lg shadow-lg overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-blue-100 text-blue-700">
                <tr>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Description</th>
                    <th class="px-4 py-3 text-left">Capacité</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($events as $event)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $event->name }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($event->event_date)->locale('fr')->translatedFormat('d F Y') }}</td>
                        <td class="px-4 py-3">{{ $event->description }}</td>
                        <td class="px-4 py-3">{{ $event->capacity }} personnes</td>
                        <td class="px-4 py-3 space-x-4 flex justify-center">
                            <!-- Afficher -->
                            <a href="{{ route('events.show', $event->id) }}" class="flex items-center space-x-2 px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300" aria-label="Voir les détails de l'événement">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7"></path>
                                </svg>
                                <span>Afficher</span>
                            </a>

                            @auth
                                <!-- Modifier -->
                                <a href="{{ route('events.edit', $event->id) }}" class="flex items-center space-x-2 px-4 py-2 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-600 transition duration-300" aria-label="Modifier cet événement">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3l5 5-7 7H6v-3l7-7 5 5z"></path>
                                    </svg>
                                    <span>Modifier</span>
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline-block" aria-label="Supprimer cet événement">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center space-x-2 px-4 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span>Supprimer</span>
                                    </button>
                                </form>
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
