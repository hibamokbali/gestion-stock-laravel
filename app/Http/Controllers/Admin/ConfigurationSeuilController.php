<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigurationSeuil;
use App\Models\Unite;
use Illuminate\Http\Request;

class ConfigurationSeuilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unites = Unite::with(['configurationSeuil', 'categorie'])
            ->where('actif', true)
            ->latest()
            ->paginate(20);

        return view('admin.seuils.index', compact('unites'));
    }

    /**
     * Formulaire de configuration pour un article
     */
    public function quickUpdate(Request $request, $unite_id)
    {
        $validated = $request->validate([
            'valeur_alerte' => 'required|numeric|min:0',
        ]);

        ConfigurationSeuil::updateOrCreate(
            ['unite_id' => $unite_id],
            [
                'valeur_alerte' => $validated['valeur_alerte'],
                'actif' => true
            ]
        );

        return redirect()->route('admin.stock.index')
            ->with('success', 'Seuil d\'alerte mis à jour avec succès');
    }
}
