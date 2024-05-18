<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Paiment extends Model
{
    use HasFactory;
    protected $table = 'paiment';

    public function getList($id)
    {
        $result = DB::table('paiment')
            ->where('ref_devis', $id)
            ->get();
        return $result;
    }

    public function insert($data){
        DB::table('paiment')->insert([
            'ref_devis' => $data['id'],
            'montant' => $data['montant'],
            'datepaiment' => $data['datepaiment'],
        ]);
    }





}
