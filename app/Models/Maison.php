<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Maison extends Model
{
    use HasFactory;
    protected $table = 'maison';

    public function getList($id)
    {
        $result = DB::table('viewtravaux')
            ->where('idmaison', $id)
            ->get();

        return $result;
    }

    public function getAllMaison()
    {
        $result = DB::table('viewmaison')
            ->get();

        return $result;
    }
}
