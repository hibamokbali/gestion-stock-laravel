<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->where('actif', true)->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('actif', true)->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'matricule' => 'nullable|string|unique:users',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'matricule' => $validated['matricule'],
            'role_id' => $validated['role_id'],
            'password' => Hash::make($validated['password']),
            'actif' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::where('actif', true)->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'matricule' => 'nullable|string|unique:users,matricule,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'matricule' => $validated['matricule'],
            'role_id' => $validated['role_id'],
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Empêcher la suppression de son propre compte
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users.index')
                    ->with('error', "Vous ne pouvez pas supprimer votre propre compte.");
            }

            // Vérifier s'il y a des entrées liées
            $entrees_count = \App\Models\Entree::where('user_id', $user->id)->count();

            // Vérifier s'il y a des sorties liées
            $sorties_count = \App\Models\Sortie::where('user_id', $user->id)->count();

            $total_operations = $entrees_count + $sorties_count;

            if ($total_operations > 0) {
                return redirect()->route('admin.users.index')
                    ->with('error', "Impossible de supprimer cet utilisateur : {$entrees_count} entrée(s) et {$sorties_count} sortie(s) enregistrées.");
            }

            // Suppression réelle
            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'Utilisateur supprimé définitivement avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
