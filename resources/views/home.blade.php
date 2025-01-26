<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center p-6">

    <!-- Barre de navigation -->
    <nav class="w-full bg-blue-500 p-4 rounded-lg shadow-md mb-6">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">Mon Profil</h1>
            <div class="flex space-x-4">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    Tableau de bord
                </a>
                <a href="{{ route('events.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                    Événements
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

    <!-- Informations de l'utilisateur -->
    <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Détails de votre profil</h2>
        <p><strong>Nom:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Créé le:</strong> {{ $user->created_at->format('d F Y') }}</p>

        <!-- Ajouter d'autres informations si nécessaire -->
    </div>

</body>
</html>
