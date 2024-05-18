<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Finition extends Model
{
    use HasFactory;

    protected $table = 'finition';

    public function getList($id)
    {
        $result = DB::table('finition')
            ->where('idfinition', $id)
            ->get();

        return $result;
    }


    public function modifier($id, $data)
    {
        DB::table('finition')
            ->where('idfinition', $id)
            ->update([
                'nom' => $data['nommodal'],
                'pourcentage' => $data['pourcentagemodal'],

            ]);
    }


}
