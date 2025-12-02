<?php

namespace App\Http\Controllers;

use App\Models\Tasca;
// Afegim el model Responsable per poder-lo utilitzar al mètode edit i create
use App\Models\Responsable; 
use Illuminate\Http\Request;

class TascaController extends Controller
{
    /**
     * Display a listing of the resource (Kanban).
     */
    public function index()
    {
        // variable correcta per Blade
        $tascas = Tasca::all(); 
        return view('tasca.index', compact('tascas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // CARREGUEM TOTS ELS RESPONSABLES per al desplegable de la vista de creació
        $responsables = Responsable::all();
        return view('tasca.create', compact('responsables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'descripcio' => 'nullable|string',
            'prioritat' => 'nullable|string',
            // El camp 'responsable' ara hauria d'estar validat si és obligatori i si existeix com a ID
            'responsable' => 'nullable|string', 
            'estat' => 'required|string',
        ]);

        // Calcular la nova posició al final de la columna
        $ultima_posicio = Tasca::where('estat', $request->estat)->max('posicio');
        $posicio = is_null($ultima_posicio) ? 0 : $ultima_posicio + 1;

        Tasca::create([
            'titol' => $request->titol,
            'descripcio' => $request->descripcio,
            'prioritat' => $request->prioritat,
            'responsable' => $request->responsable,
            'estat' => $request->estat,
            'posicio' => $posicio,
        ]);

        return redirect()->route('tasca.index')->with('success', 'Tasca creada correctament!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 1. Recuperar la tasca
        $tasca = Tasca::findOrFail($id);
        
        // 2. Recuperar la llista de responsables per al desplegable de la vista
        $responsables = Responsable::all(); 
        
        // 3. Retornar la vista amb la tasca i la llista de responsables
        return view('tasca.edit', compact('tasca', 'responsables'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'descripcio' => 'nullable|string',
            'prioritat' => 'nullable|string',
            'responsable' => 'nullable|string',
            'estat' => 'required|string',
        ]);

        $tasca = Tasca::findOrFail($id);
        
        // Si l'estat canvia des del formulari d'edició, cal reordenar l'antiga columna.
        $estat_antic = $tasca->estat;
        $nou_estat = $request->estat;

        $tasca->update([
            'titol' => $request->titol,
            'descripcio' => $request->descripcio,
            'prioritat' => $request->prioritat,
            'responsable' => $request->responsable,
            'estat' => $nou_estat,
        ]);

        // Si l'estat ha canviat, reordenar la columna d'origen per omplir el forat.
        if ($estat_antic != $nou_estat) {
            Tasca::where('estat', $estat_antic)
                ->orderBy('posicio')
                ->get()
                ->each(function ($t, $index) {
                    if ($t->posicio != $index) {
                        $t->posicio = $index;
                        $t->save();
                    }
                });
            
            // Recalcular posició al final de la nova columna
            $ultima_posicio = Tasca::where('estat', $nou_estat)->max('posicio');
            $nova_posicio = is_null($ultima_posicio) ? 0 : $ultima_posicio + 1;

            $tasca->update(['posicio' => $nova_posicio]);
        }


        return redirect()->route('tasca.index')->with('success', 'Tasca actualitzada correctament!');
    }

    /**
     * Remove the specified resource from storage (AJAX compatible).
     */
    public function destroy(string $id)
    {
        try {
            $tasca = Tasca::findOrFail($id);
            $estat_tasca = $tasca->estat; // Guardem l'estat abans d'eliminar
            $tasca->delete();

            // Després d'eliminar, reordenar la columna per mantenir la seqüència.
            Tasca::where('estat', $estat_tasca)
                ->orderBy('posicio')
                ->get()
                ->each(function ($t, $index) {
                    // Només actualitzem si la posició ha canviat
                    if ($t->posicio != $index) {
                        $t->posicio = $index;
                        $t->save();
                    }
                });

            // RETORNAR RESPOSTA JSON PER A AJAX
            return response()->json(['success' => true, 'message' => 'Tasca eliminada i columna reordenada correctament.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Tasca no trobada.'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error en eliminar la tasca.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Actualitza posició i estat (drag & drop Kanban).
     */
    public function updateKanban(Request $request)
    {
        // 1. Validació de dades
        $data = $request->validate([
            'id_tasca' => 'required|integer|exists:tascas,id_tasca',
            'estat' => 'required|string',
            'posicio' => 'required|integer',
        ]);

        $tasca = Tasca::findOrFail($data['id_tasca']);
        $estat_antic = $tasca->estat;
        $nou_estat = $data['estat'];
        $nova_posicio = $data['posicio'];

        // 2. Actualitzar l'estat i la posició temporalment (la definitiva es farà al pas 6)
        $tasca->update([
            'estat' => $nou_estat,
            'posicio' => $nova_posicio,
        ]);

        // 3. Reordenar TOTS els elements de la nova columna (excloent la tasca arrossegada inicialment)
        $tasques_columna = Tasca::where('estat', $nou_estat)
                               ->where('id_tasca', '!=', $tasca->id_tasca) // Carregar la resta de tasques
                               ->orderBy('posicio')
                               ->get();

        // 4. Inserir la tasca arrossegada a la seva nova posició utilitzant Col·leccions de Laravel
        // La funció splice afegeix l'element $tasca a la $nova_posicio sense reemplaçar (0)
        $tasques_columna->splice($nova_posicio, 0, [$tasca]);

        // 5. Reassignar posicions definitives a la columna de destí
        foreach ($tasques_columna as $index => $t) {
            // Guardar només si la posició ha canviat per optimització
            if ($t->posicio !== $index) {
                $t->posicio = $index;
                $t->save();
            }
        }

        // 6. [OPCIONAL, PERÒ RECOMANAT] Si l'estat ha canviat, reordenar la columna d'origen per omplir el forat.
        if ($estat_antic !== $nou_estat) {
            Tasca::where('estat', $estat_antic)
                ->orderBy('posicio')
                ->get()
                ->each(function ($t, $index) {
                    // Guardar només si la posició ha canviat
                    if ($t->posicio !== $index) {
                        $t->posicio = $index;
                        $t->save();
                    }
                });
        }

        return response()->json(['success' => true]);
    }
}