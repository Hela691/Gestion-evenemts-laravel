<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // Ici, récupérez les informations de l'utilisateur connecté
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

     // Mettre à jour le profil de l'utilisateur
     public function update(Request $request)
     {

         /** @var \App\Models\User $user */
         $user = Auth::user();
 
         // Validation des données
         $validated = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:users,email,' . $user->id, // L'email doit être unique sauf pour l'utilisateur actuel
         ]);
 
         try {
             // Mettre à jour les informations de l'utilisateur
             $user->update([
                 'name' => $validated['name'],
                 'email' => $validated['email'],
             ]);
 
             // Message de succès
             return redirect()->route('profile')->with('success', 'Votre profil a été mis à jour avec succès.');
 
         } catch (\Exception $e) {
             // En cas d'erreur, tu peux loguer l'erreur ou envoyer un message
             return redirect()->route('profile')->with('error', 'Une erreur est survenue. Veuillez réessayer plus tard.');
         }
     }
}

