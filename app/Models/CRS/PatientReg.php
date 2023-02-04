<?php

namespace App\Models\CRS;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientReg extends Model
{
    use HasFactory;
    protected $table="patient_reg";

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
               ->where('labno', 'like', '%'.$search.'%')
               ->orWhere('batchno', 'like', '%'.$search.'%')
               ->orWhere('worksheet', 'like', '%'.$search.'%')
               ->orWhere('name', 'like', '%'.$search.'%')
               ->orWhere('passport', 'like', '%'.$search.'%')
               ->orWhere('entrydate', 'like', '%'.$search.'%');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logFillable()
        ->useLogName('labno')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    

}
