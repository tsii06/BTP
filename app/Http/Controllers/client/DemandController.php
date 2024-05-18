<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\client\Demand;
use App\Models\Finition;
use App\Models\Maison;
use App\Models\Paiment;
use App\Models\Travaux;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use TCPDF;

class DemandController extends Controller
{
    public function demand()
    {
        $maiso = new Maison();
        $maison = $maiso->getAllMaison();
        $finition  = Finition::all();
        return view('client.demand', [
            'maisons' => $maison,
            'finition' => $finition
        ]);
    }
    public function liste(Request $request){
        $devis = new Demand();
        $id = $request->session()->get('client');
        $all = $devis->getList($id);
        return view('client.liste', [
            'devis' =>$all
        ]);
    }

    public function insert(Request $request){

        $data = $request->validate([
            'idmaison' => 'required',
            'idfinition' => 'required',
            'datedebut' => 'required',
            'lieu' => 'required',
        ]);
        $data['dateinsertion'] = now();

        $idmaison = $request->input('idmaison');
        $idfinition = $request->input('idfinition');

        $id = $request->session()->get('client');
        $data['idclient'] = $id;

        $client = new Demand();
        $iddevis = $client->insert($data);

        $maison = new Maison();
        $travauxMaison = $maison->getList($idmaison);
        foreach ($travauxMaison as $travaux){
            DB::table('detaildevis')->insert([
                'reference' => $iddevis,
                'idtravaux' => $travaux->idtravaux,
                'prixunitaire' => $travaux->prixunitaire,
                'quantite' => $travaux->quantite,
            ]);
        }

        $finition = new Finition();

        $finitions = $finition->getList($idfinition);
        foreach ($finitions as $fin){
            DB::table('detailfinition')->insert([
                'reference' => $iddevis,
                'idfinition' => $fin->idfinition,
                'pourcentage' => $fin->pourcentage,
            ]);
        }



        return redirect()->route('client.demand')->with('success', 'client créé avec succès!');
    }

    public function export($id){
        $devis = new Demand();
        $all = $devis->getDevis($id);
        $total = $devis->getInfo($id);

        $paiment = new Paiment();
        $payer = $paiment->getList($id);
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->writeHTML(view('client.export', ['devis' => $all,'total'=>$total,'paiment'=>$payer])->render());
        $pdf->Output('exemple.pdf');
    }

//    public function export($id){
//        $devis = new Demand();
//        $paiment = new Paiment();
//        $all = $devis->getDevis($id);
//        $total = $devis->getInfo($id);
//        $payer = $paiment->getList($id);
//        return view('client.export', [
//            'devis' =>$all,
//            'total' => $total,
//            'paiment' =>$payer
//        ]);
//    }

    public function paiment($id){
        $paiment = new Paiment();
        $demand = new Demand();
        $paiments = $paiment->getList($id);
        $total = $demand->getDetailDevis($id);
//        dd($id);

        return view('client.paiment', [
            'paiments' => $paiments,
            'id' => $id,
            'total' => $total
        ]);
    }


    public function insertpaiment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'montant' => 'required|numeric|min:0',
            'datepaiment' => 'required',
        ], [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être supérieur ou égal à zéro.',
            'datepaiment.required' => 'La date de paiement est obligatoire.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $mes = '';
            foreach ($errors as $error){
                $mes = $mes.'=>'.$error;
            }
            return response()->json(['errors' =>$mes], 422);
        }

        $data = $request->all();
        $demand = new Demand();
        $detail = $demand->getDetailDevis($data['id']);


        if ($detail->reste < $data['montant']) {
            return response()->json(['error' => 'Le montant total payé dépasse le montant total restant à payer.'.number_format($detail->reste, 2, ',', ' ') .''], 422);
        } else {
            $paiment = new Paiment();
            $paiment->insert($data);
            return response()->json(['success' => 'Paiement créé avec succès!'], 200);
        }
    }




}
