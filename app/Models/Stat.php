<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stat extends Model
{
    use HasFactory;

    public function showHistogram($year)
    {
        return DB::select("
        WITH allMonths AS (
            SELECT generate_series(
                date_trunc('year', '{$year}-01-01'::date),
                date_trunc('year', '{$year}-01-01'::date) + INTERVAL '1 year - 1 day',
                INTERVAL '1 month'
            ) AS month
        )
        SELECT
            TO_CHAR(allMonths.month, 'MM') AS month,
            COALESCE(SUM(total), 0) AS total
        FROM
            allMonths
        LEFT JOIN
            viewdevis1 ON date_trunc('month', viewdevis1.dateinsertion) = allMonths.month
        GROUP BY
            month
        ORDER BY
            month;
    ");

    }
}
