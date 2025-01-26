<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord des événements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    
    <!-- Barre de navigation -->
    <nav class="w-full bg-blue-500 p-4 rounded-lg shadow-md mb-6">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">Tableau de bord</h1>
            <div class="flex space-x-4">
                
                <a href="{{ route('events.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                    Événements
                </a>
                <a href="{{ route('profile') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Tableau de bord des événements</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Cartes récapitulatives -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-gray-500 uppercase text-sm mb-2">Total des événements</div>
                        <div class="text-4xl font-bold text-blue-600">{{ $totalEvents }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-500 uppercase text-sm mb-2">Participants</div>
                        <div class="text-4xl font-bold text-green-600">{{ $totalParticipants }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-500 uppercase text-sm mb-2">À venir</div>
                        <div class="text-4xl font-bold text-orange-600">{{ $upcomingEvents }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-500 uppercase text-sm mb-2">Moyenne par événement</div>
                        <div class="text-4xl font-bold text-purple-600">{{ number_format($averageParticipants, 2) }}</div>
                    </div>
                </div>
            </div>

            <!-- Espace pour une future visualisation -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Aperçu des événements</h3>
                <div class="text-center text-gray-500">
                    Visualisations détaillées à venir
                </div>
            </div>
        </div>
    </div>

</body>

</html>
