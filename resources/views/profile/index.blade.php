<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-r from-purple-600 to-blue-500 min-h-screen flex flex-col items-center justify-center p-4">

    <!-- Barre de navigation fixée en haut -->
    <nav class="w-full bg-white/90 backdrop-blur-sm p-4 rounded-lg shadow-2xl mb-6 fixed top-0 left-0 right-0 z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Mon Profil</h1>
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

    <!-- Ajout d'un espace de décalage pour ne pas que le contenu soit masqué sous la navbar -->
    <div class="w-full mt-20 flex items-center justify-center">

        <!-- Message de succès -->
        @if(session('success'))
            <div class="w-full max-w-lg bg-green-100 text-green-800 text-center p-4 mt-6 rounded-md shadow-md">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Message d'erreur -->
        @if(session('error'))
            <div class="w-full max-w-lg bg-red-100 text-red-800 text-center p-4 mt-6 rounded-md shadow-md">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Informations de l'utilisateur -->
        <div class="w-full max-w-lg bg-white/90 backdrop-blur-sm p-6 rounded-xl shadow-xl transform transition-all hover:scale-105 duration-300">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 text-center">Détails de votre profil</h2>
            <p><strong>Nom:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Créé le:</strong> {{ $user->created_at->format('d F Y') }}</p>

            <!-- Formulaire pour modifier le profil -->
            <h2 class="text-xl font-semibold mt-6 mb-4 text-gray-800 text-center">Modifier votre profil</h2>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    Mettre à jour
                </button>
            </form>
        </div>
    </div>

</body>
</html>
