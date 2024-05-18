<?php

namespace App\Http\Controllers;

use App\Models\Travaux;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TravauxController extends Controller
{

    public function insert()
    {
        $travaux = new Travaux();
        $travauxs = $travaux::paginate(5);

        return view('travaux.insert', [
            'travauxs' => $travauxs,

        ]);
    }

    public function modifier(Request $request)
    {
        $id = $request->input('idtravaux');
        $data = $request->validate([
            'codemodal' => 'required',
            'designationmodal' => 'required',
            'unitemodal' => 'required',
            'prixunitairemodal' => 'required|numeric',

        ]);
        $travaux = new Travaux();
        $travaux->modifier($id, $data);

        return redirect()->route('travaux.ressource')->with('success', 'travaux modifié avec succès!');
    }
    public function destroy($id)
    {
        try {
            DB::table('travaux')
                ->where('idtravaux', $id)
                ->delete();

            return redirect()->route('travaux.ressource')->with('success', 'travaux supprimé avec succès!');
        } catch (\Exception $e) {
            // Gestion de l'erreur ici
            return redirect()->route('travaux.ressource')->with('error', 'Une erreur est survenue lors de la suppression du travaux.');
        }
    }


}
