<?php

namespace App\Models\CRS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wagonjwa extends Model
{
    use HasFactory;

    protected $fillable = ['lab_no', 'patient_id', 'Facility name', 'priority', 'test_reason',  'worksheet_no', 'test_type', 'platform', 'test_kit', 'result', 'target1', 'ct_value', 'target2', 'ct_value2', 'target3', 'ct_value3',
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
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
}
