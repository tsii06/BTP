<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Travaux extends Model
{
    use HasFactory;
    protected $table = 'travaux';

    public function getList(){
        $result = DB::select("SELECT * FROM travaux");
        return $result;
    }


    public function modifier($id, $data){
        DB::table('travaux')
            ->where('idtravaux', $id)
            ->update([
                'code' => $data['codemodal'],
                'designation' => $data['designationmodal'],
                'unite' => $data['unitemodal'],
                'prixunitaire' => $data['prixunitairemodal'],

            ]);
    }


}
