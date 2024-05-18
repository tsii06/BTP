<?php

namespace App\Http\Controllers;

use App\Imports\Impo;
use App\Models\Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
//    public function csv(Request $request)
//    {
//        $travaux = $request->file('file1');
//        $devis = $request->file('file2');
//        $tra = array_map(function($line) {
//            return str_getcsv($line, ';');
//        }, file($travaux));
//
//        $de = array_map(function($line) {
//            return str_getcsv($line, ';');
//        }, file($devis));
//
//        $import = new Import();
//        $errors = $import->stock($de,$tra);
//
//        if (count($errors)>0) {
//            return redirect()->intended('/import')->with('errors', $errors);
//        } else {
//            return redirect()->intended('/import')->with('succes', 'Importation réussie');
//        }
//    }

    public function csv(Request $request)
    {
        $travaux = $request->file('file1');
        $devis = $request->file('file2');

        $tra = array_map(function($line) {
            return str_getcsv($line, ',', '"');
        }, file($travaux->getRealPath()));

        $de = array_map(function($line) {
            return str_getcsv($line, ',', '"');
        }, file($devis->getRealPath()));

        $import = new Import();
        $errors = $import->stock($de, $tra);

        if (count($errors) > 0) {
            return redirect()->intended('/import')->with('errors', $errors);
        } else {
            return redirect()->intended('/import')->with('succes', 'Importation réussie');
        }
    }



//    public function csv(Request $request)
//    {
//        $travauxFile = $request->file('file1');
//        $devisFile = $request->file('file2');
//
//
//        try {
//            // Convert CSV/Excel files to arrays using Excel::toArray
//            $travauxData = Excel::toArray(new Impo(),$travauxFile)[0];
//            $devisData = Excel::toArray(new Impo(),$devisFile)[0];
//
//            // Instantiate Import class and store data
//            $import = new Import();
//            $errors = $import->stock($devisData, $travauxData);
//
//            if (count($errors) > 0) {
//                return Redirect::intended('/import')->with('errors', $errors);
//            } else {
//                return Redirect::intended('/import')->with('success', 'Importation réussie');
//            }
//        } catch (\Exception $e) {
//            return Redirect::intended('/import')->with('errors', ['Erreur lors de l\'importation des fichiers : ' . $e->getMessage()]);
//        }
//    }

    public function paiment(Request $request)
    {
        $file = $request->file('csv_file');
        $data = array_map(function($line) {
            return str_getcsv($line, ',');
        }, file($file));
        $import = new Import();
        $errors = $import->stockPaiment($data);
        if (count($errors)>0) {
            return redirect()->intended('/import/paiment')->with('errors', $errors);
        } else {
            return redirect()->intended('/import')->with('succes', 'Importation réussie');
        }
    }
}
