<?php

namespace App\Http\Livewire\Crs;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\CRS\wagonjwa;
use Illuminate\Support\Facades\DB;

class ExternalPatientEntry extends Component
{
    public $external_patients;

    public function mount()
    {
        
            // return $patient;
            $client = new Client(['base_uri' => 'https://apitest.cphluganda.org/covid_suspects', 'verify' => false]);
            try {
                $res = $client->request('GET', 'https://apitest.cphluganda.org/covid_suspects',[
                    'auth' => [
                        'uvri_lims', '4B>{jaE54^_azqR['
                    ]
                ]);
    
                $data = collect(json_decode($res->getBody(), true));
                // dd($data);
                $this->external_patients=$data;
                // return response()->json($external_patients);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
    
                // dd($e->getMessage());
                $this->external_patients = collect([]);
            }

    }

    public function claimPatient($caseId)
    {
        $patient=$this->external_patients->where('caseID',$caseId)->first();
        $latestPatNo = Wagonjwa::select('pat_no')->whereNotNull('pat_no')->orderBy('id', 'desc')->first();
        if ($latestPatNo) {
            $pat_no = 'BRC-'.(substr(explode('-', $latestPatNo->pat_no)[1], 0, -1) + 1).'P';
        } else {
            $pat_no = 'BRC-10000P';
        }

        if($patient){
            DB::transaction(function () use($patient,$pat_no){
                wagonjwa::updateOrCreate([
                    'patient_id'=>$patient['caseID'],
    
                ],[
                    'pat_no'=>$pat_no,
                    'patient_id'=>$patient['caseID'],
                    'surname' => $patient['patient_surname'],
                    'given_name' => $patient['patient_firstname'],
                    'priority'=>'Normal',
                    'who_tested' => 'Alert',
                    'test_reason' => 'Routine Exposure',
                    'gender' => $patient['sex'],
                    'age'=>$patient['age'],
                    'phone_number'=>$patient['patient_contact'],
                    'nationality' => $patient['nationality'],
                    'patient_district' => $patient['swabing_district'],
                    'swab_district' => $patient['swabing_district'],
                    'collection_date' => $patient['specimen_collection_date'],
                    'collected_by' => 245,
                    'sample_type' => $patient['sample_type'],
                    'entry_type' => 'RDS',
                    'facility_id'=>70
                ]);
            });

            dd('success');
        }else{
                    // $this->dispatchBrowserEvent('swal:modal', [
        //     'type' => 'warning',
        //     'message' => 'Not Found!',
        //     'text' => 'Oops! No Trainers selected for export!',
        // ]);
        }
       
    }
    
    public function render()
    {
        return view('livewire.crs.external-patient-entry');
    }
}
