<?php

namespace App\Models\CRS;

use App\Models\CRS\Facility;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class wagonjwa extends Model
{
    use HasFactory,LogsActivity,CausesActivity;
 
    protected $fillable = [
        'surname',
        'given_name',
        'priority',
        'who_tested',
        'test_reason',
        'gender',
        'age',
        'phone_number',
        'nationality',
        'patient_district',
        'swab_district',
        'collection_date',
        'collected_by',
        'sample_type',
        'sample_id',
        'entry_type',
        'facility_id',
        'lab_no', 
        'patient_id',
        'pat_no',
        'Facility name', 
        'priority', 
        'test_reason',  
        'worksheet_no', 
        'test_type', 
        'platform', 
        'test_kit', 
        'result', 
        'target1', 
        'ct_value', 
        'target2', 
        'ct_value2', 
        'target3', 
        'ct_value3',
        'tat',
        'results_approver_name',
        'approver_signature',
        'igg_result',
        'igm_result',
        'result_added_by',
        'result_updated_at',
        'result_added_at',
        'status',
        'print_count',
        'import_batch',
        'created_by',
        'ever_been_vaccinated',
        'ever_been_positive',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
               ->where('lab_no', 'like', '%'.$search.'%')
               ->orWhere('patient_id', 'like', '%'.$search.'%')
               ->orWhere('worksheet_no', 'like', '%'.$search.'%')
               ->orWhere('surname', 'like', '%'.$search.'%')
               ->orWhere('given_name', 'like', '%'.$search.'%')
               ->orWhere('other_name', 'like', '%'.$search.'%');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logFillable()
        ->useLogName('wagonjwas')
        ->dontLogIfAttributesChangedOnly(['updated_at'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

}
