<?php

namespace App\Imports;

use App\Models\CRS\wagonjwa;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class resultsImport implements ToModel, WithStartRow, WithUpserts
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'lab_no';
    }

    public function model(array $row)
    {
        // $batch = rand(1000,7878).time();
        $batch = request()->input('batch');
        $today = Carbon::now();
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $today);
        //$from = Carbon::createFromFormat('Y-m-d H:s:i', $row[15]);
        //$tat = $to->diffInHours(Carbon::createFromFormat('Y-m-d H:s:i', $row[15]));
        return new wagonjwa([
            'lab_no' => $row[0],
            'patient_id' => $row[1],
            'test_reason' => $row[3],
            'worksheet_no' => $row[4],
            'test_type' => $row[5],
            'platform' => $row[6],
            'test_kit' => $row[7],
            'result' => $row[8],
            'target1' => $row[9],
            'ct_value' => $row[10],
            'target2' => $row[11],
            'ct_value2' => $row[12],
            'target3' => $row[13],
            'ct_value3' => $row[14],
            'tat' => $to->diffInHours($row[15]),
            'results_approver_name' => 'Edgar Kigozi',
            'approver_signature' => 'Edgar Kigozi',
            'igg_result' => 'NA',
            'igm_result' => 'NA',
            'result_added_by' => auth()->user()->id,
            'result_updated_at' => date('Y-m-d H:i:s'),
            'result_added_at' => date('Y-m-d H:i:s'),
            'status' => 'Completed',
            'import_batch' => $batch,
        ]);

    //     foreach (failures() as $failure) {
    //         $failure->row(); // row that went wrong
    //         $failure->attribute(); // either heading key (if using heading row concern) or column index
    //         $failure->errors(); // Actual error messages from Laravel validator
    //         $failure->values(); // The values of the row that has failed.
    //    }
    }

    public function batchSize(): int
    {
        return 5;
    }

    // public function chunkSize(): int
    // {
    //     return 100;
    // }
}
