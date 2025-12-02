<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    /**
     * Mostra una llista de tots els responsables.
     * En un entorn real, aquesta llista seria la base per a una taula de gestió d'usuaris.
     */
    public function index()
    {
        // Recupera tots els responsables de la base de dades
        $responsables = Responsable::all();
        
        // Retorna la vista amb la llista (assumim que tens una vista 'responsable.index')
        return view('responsable.index', compact('responsables'));
    }

    /**
     * Mostra el formulari per crear un nou responsable.
     */
    public function create()
    {
        // Retorna la vista del formulari de creació
        return view('responsable.create');
    }

    /**
     * Desa un recurs nou a l'emmagatzematge.
     */
    public function store(Request $request)
    {
        // 1. Validació de dades
        $request->validate([
            'nom' => 'required|string|max:255',
            'cognom' => 'required|string|max:255',
            'edat' => 'required|integer|min:18',
        ]);

        // 2. Creació del recurs
        Responsable::create($request->only(['nom', 'cognom', 'edat']));

        // 3. CANVI: Redirecció enrere (a la mateixa pàgina de creació) amb missatge d'èxit
        // Això permet crear múltiples responsables ràpidament sense canviar de pàgina.
        return redirect()->back()->with('success', 'Responsable creat amb èxit!');
    }

    /**
     * Mostra el recurs especificat (no molt comú per a models simples com aquest).
     */
    public function show(string $id)
    {
        // Troba el responsable per la seva clau primària
        $responsable = Responsable::findOrFail($id);

        // Retorna la vista de detall
        return view('responsable.show', compact('responsable'));
    }

    /**
     * Mostra el formulari per editar el recurs especificat.
     */
    public function edit(string $id)
    {
        // Troba el responsable a editar
        $responsable = Responsable::findOrFail($id);

        // Retorna la vista d'edició
        return view('responsable.edit', compact('responsable'));
    }

    /**
     * Actualitza el recurs especificat a l'emmagatzematge.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validació de dades (similar a store)
        $request->validate([
            'nom' => 'required|string|max:255',
            'cognom' => 'required|string|max:255',
            'edat' => 'required|integer|min:18',
        ]);

        // 2. Troba i actualitza el responsable
        $responsable = Responsable::findOrFail($id);
        $responsable->update($request->only(['nom', 'cognom', 'edat']));

        // 3. Redirecció i missatge de confirmació
        return redirect()->route('responsable.index')->with('success', 'Responsable actualitzat amb èxit!');
    }

    /**
     * Elimina el recurs especificat de l'emmagatzematge.
     */
    public function destroy(string $id)
    {
        // Troba i elimina el responsable
        $responsable = Responsable::findOrFail($id);
        $responsable->delete();

        // Redirecció i missatge de confirmació
        return redirect()->route('responsable.index')->with('success', 'Responsable eliminat amb èxit!');
    }
}