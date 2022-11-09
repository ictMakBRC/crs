<?php

namespace App\Exports;

use App\Models\CRS\wagonjwa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PatientsExport implements FromCollection,WithMapping,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        $this->count=0;
    }

    public function collection()
    {
        return Wagonjwa::orderBy('created_at','desc')->get();
    }
    
    public function map($wagonjwa) : array {
        // $this->count++;
        // if($wagonjwa->user==null){
        //     $user='N/A';
        // }else{
        //     $user= $wagonjwa->user->name;
        // }
        // if($wagonjwa->vendor==null){
        //     $vendor='N/A';
        // }else{
        //     $vendor=$wagonjwa->vendor->vendor_name;
        // }
        // if($wagonjwa->insurer==null){
        //     $insurer='N/A';
        // }else{
        //   $insurer= $wagonjwa->insurer->vendor_name;
        // }
        // if($wagonjwa->insurancetype==null){
        //     $type='N/A';
        // }else{
        //   $type= $wagonjwa->insurancetype->type;
        // }
        return [
            // $this->count,
            // $wagonjwa->patient_id,
            // $wagonjwa->pat_no,
            // $wagonjwa->surname,
            // $wagonjwa->given_name,
            // $wagonjwa->other_name,
            // $wagonjwa->priority,
            // $wagonjwa->dob,
            // $wagonjwa->nok_name,
            // $wagonjwa->patient_email,
            // $wagonjwa->doc_type,
            // $wagonjwa->doc_no,
            // $wagonjwa->facility_id,
            // $wagonjwa->who_tested,
            // $wagonjwa->test_reason,
            // $wagonjwa->gender,
            // $wagonjwa->age,
            // $wagonjwa->phone_number,
            // $wagonjwa->nationality,
            // $wagonjwa->patient-district,
            // $wagonjwa->swab_district,
            $wagonjwa->collection_date,
            $wagonjwa->date_received,
            $wagonjwa->accessioned_at,
            $wagonjwa->entered_at,
            $wagonjwa->result_added_at,
            $wagonjwa->created_at,
            // Carbon::parse($wagonjwa->event_date)->toFormattedDateString(),
            // Carbon::parse($wagonjwa->created_at)->toFormattedDateString()
        ] ;
        
    }

    public function headings() : array {
        return [
            // '#',
           'collection_date',
           'date_received',
           'accessioned_at',
           'entered_at',
           'result_added_at',
           'created_at',
        ] ;
    }


}
