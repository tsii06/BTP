<?php

namespace App\Http\Controllers;

use App\Models\Finition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinitionController extends Controller
{

    public function insert()
    {
        $finition = new Finition();
        $finitions = $finition::paginate(4);

        return view('finition.insert', [
            'finitions' => $finitions,

        ]);
    }

    public function modifier(Request $request)
    {
        $id = $request->input('idfinition');
        $data = $request->validate([
            'nommodal' => 'required',
            'pourcentagemodal' => 'required|numeric',

        ]);
        $finition = new Finition();
        $finition->modifier($id, $data);

        return redirect()->route('finition.ressource')->with('success', 'finition modifié avec succès!');
    }
    public function destroy($id)
    {
        try {
            DB::table('finition')
                ->where('idfinition', $id)
                ->delete();

            return redirect()->route('finition.ressource')->with('success', 'finition supprimé avec succès!');
        } catch (\Exception $e) {
            // Gestion de l'erreur ici
            return redirect()->route('finition.ressource')->with('error', 'Une erreur est survenue lors de la suppression du finition.');
        }
    }


}
