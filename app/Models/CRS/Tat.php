<?php

namespace App\Models\CRS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tat extends Model
{
    use HasFactory;
    protected $table="tat_per_entry";

    public function propotioninrange()
    {
        return $this->whereNotNull('result')->where('ReceiptToResult','<=',1440)
        ->select('DateCreated',DB::raw('count(ReceiptToResult) AS TotalWithIn'));   
    }

    public static function propotioninrangeh()
    {
        return  static::query()
                ->whereNotNull('result')->where('ReceiptToResult','<=',1440)
                ->select('DateCreated',DB::raw('count(ReceiptToResult) AS TotalWithIn'));
    }
}
