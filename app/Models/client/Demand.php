<?php

namespace App\Models\client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Demand extends Model
{
    use HasFactory;
    public function insert($data)
    {
        return DB::table('devisclient')->insertGetId([
            'idclient' => $data['idclient'],
            'idmaison' => $data['idmaison'],
            'idfinition' => $data['idfinition'],
            'datedebut' => $data['datedebut'],
            'dateinsertion' => $data['dateinsertion'],
            'lieu' => $data['lieu']
        ],'reference');
    }

    public function getList($id)
    {
        $result = DB::table('viewdevis1')
            ->where('idclient', $id)
            ->paginate(3);

        return $result;
    }

    public function getAll()
    {
        $result = DB::table('viewdevis1')
            ->paginate(6);

        return $result;
    }

    public function  getDevis($id){
        $result = DB::table('viewdetaildevis')
            ->where('reference', $id)
            ->get();

        return $result;
    }

    public function getDetailDevis($iddevisclient)
    {
        return DB::table('getpayer')
            ->where('reference', $iddevisclient)->first();
    }

    public function getInfo($reference){
        $result = DB::table('viewdevis1')
            ->where('reference', $reference)
            ->first();
        return $result;
    }





}
