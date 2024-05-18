<?php

namespace App\Http\Controllers;

use App\Models\client\Demand;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stat = new Stat();

        $year= '2024';
        $annee = DB::table('viewdevis1')
            ->select(DB::raw('DISTINCT EXTRACT(YEAR FROM dateinsertion) as year'))
            ->orderBy('year')
            ->get();
        $results = $stat->showHistogram($year);

        $totalSum = DB::table('viewdevis1')->sum('total');
        $totalPaiement = DB::table('viewdevis1')->sum('payer');

        return view('admin.dashboard',[
            'results' => $results,
            'annee' => $annee,
            'total' => $totalSum,
            'paiement' => $totalPaiement
        ]);
    }
    public function showHistogram($year)
    {
        $stat = new Stat();
        $results = $stat->showHistogram($year);
        return response()->json($results);
    }

    public function listedevis(){
        $devis = new Demand();
        $all = $devis->getAll();
        return view('admin.listedevis', [
            'devis' =>$all
        ]);
    }

    public function details($id){
        $devis = new Demand();
        $all = $devis->getDevis($id);
        $total = $devis->getInfo($id);
        return view('admin.details', [
            'devis' =>$all,
            'total' => $total
        ]);
    }

    public function trun(){
        $tables = Schema::getAllTables();
        DB::statement('SET session_replication_role =replica');
        DB::beginTransaction();

        try{
            foreach ($tables as $table){
                DB::table($table->tablename)->truncate();
            }
            DB::commit();
        }catch (\Exception $e){

        } finally {
            DB::statement('SET session_replication_role = DEFAULT');
            $user = User::create([
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
            ]);
        }
    }
}
