<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Événements</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Ajouter Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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

    <!-- Barre de recherche -->
    <div class="w-full max-w-lg mb-6 flex items-center space-x-4">
        <form action="{{ route('events.index') }}" method="GET" class="flex items-center space-x-4">
            <input type="text" name="search" value="{{ request()->query('search') }}" placeholder="Rechercher un événement..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                <i class="fas fa-search"></i> <!-- Icône de recherche -->
            </button>
        </form>

        <!-- Lien pour réinitialiser la recherche -->
        @if(request()->query('search'))
            <a href="{{ route('events.index') }}" class="ml-4 text-blue-500 hover:text-blue-700">Réinitialiser la recherche</a>
        @endif
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="w-full max-w-lg bg-green-100 text-green-800 text-center p-4 mt-6 rounded-md shadow-md">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Création d'un événement -->
    @auth
        <div class="w-full max-w-lg text-right mt-6">
            <a href="{{ route('events.create') }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300 flex items-center justify-center space-x-2">
                <i class="fas fa-plus-circle"></i> <!-- Icône de création -->
                <span>Créer un événement</span>
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
                                <i class="fas fa-eye"></i> <!-- Icône de visualisation -->
                                <span>Afficher</span>
                            </a>

                            @auth
                                <!-- Modifier -->
                                <a href="{{ route('events.edit', $event->id) }}" class="flex items-center space-x-2 px-4 py-2 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-600 transition duration-300" aria-label="Modifier cet événement">
                                    <i class="fas fa-edit"></i> <!-- Icône de modification -->
                                    <span>Modifier</span>
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline-block" aria-label="Supprimer cet événement">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center space-x-2 px-4 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 transition duration-300">
                                        <i class="fas fa-trash-alt"></i> <!-- Icône de suppression -->
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
