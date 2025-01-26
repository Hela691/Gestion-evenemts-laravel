<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un événement</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-r from-purple-600 to-blue-500 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white/90 backdrop-blur-sm rounded-xl shadow-2xl p-8 transform transition-all hover:scale-105 duration-300">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Modifier l'événement</h2>

        <form action="{{ route('events.update', $event->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="relative">
                <input 
                    type="text" 
                    name="name"
                    value="{{ old('name', $event->name) }}"
                    placeholder="Nom de l'événement"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                    required
                >
                <label class="absolute left-3 -top-2.5 bg-white px-1 text-xs text-gray-500">Nom</label>
            </div>

            <div class="relative">
                <textarea 
                    name="description"
                    placeholder="Description de l'événement"
                    rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                    required
                >{{ old('description', $event->description) }}</textarea>
                <label class="absolute left-3 -top-2.5 bg-white px-1 text-xs text-gray-500">Description</label>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="relative">
                    <input 
                        type="date" 
                        name="event_date"
                        value="{{ old('event_date', $event->event_date) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                        required
                    >
                    <label class="absolute left-3 -top-2.5 bg-white px-1 text-xs text-gray-500">Date</label>
                </div>

                <div class="relative">
                    <input 
                        type="number" 
                        name="capacity"
                        value="{{ old('capacity', $event->capacity) }}"
                        min="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                        placeholder="Capacité"
                        required
                    >
                    <label class="absolute left-3 -top-2.5 bg-white px-1 text-xs text-gray-500">Capacité</label>
                </div>
            </div>

            <button 
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-300"
            >
                Mettre à jour l'événement
            </button>
        </form>
    </div>
</body>
</html>