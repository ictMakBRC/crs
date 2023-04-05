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
        $client = new Client(['base_uri' => 'https://apitest.cphluganda.org/covid_suspects', 'verify' => false]);
        try {
            $res = $client->request('GET', 'https://apitest.cphluganda.org/covid_suspects',[
                'auth' => [
                    'uvri_lims', '4B>{jaE54^_azqR['
                ]
            ]);

            $data = collect(json_decode($res->getBody(), true));
            $this->external_patients=$data;
            
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->external_patients = collect([]);
        }

    }

  

    public function claimPatient($patient_identifier)
    {
        $patient=$this->external_patients->where('patient_identifier',$patient_identifier)->first();
        $patNumber = Wagonjwa::where('patient_id',$patient['patient_identifier'])->value('patient_id');
        $latestPatNo = Wagonjwa::select('pat_no')->whereNotNull('pat_no')->orderBy('id', 'desc')->first();
        //$count=Wagonjwa::count();
        if ($latestPatNo) {
            $pat_no = 'BRC-'.(substr(explode('-', $latestPatNo->pat_no)[1], 0, -1) + 1).'P';
        } else {
            $pat_no = 'BRC-10000P';
        }

        // dd($patNumber);

        if($patient && $patient['patient_identifier']!='' && $patient['specimen_uuid']!='' && $patNumber==null){
            DB::transaction(function () use($patient,$pat_no){
                // dd($patient);

                $fullName = $patient['patient_surname'];
                $nameArray = explode(" ", $fullName);

                $given_name = $nameArray[0]; // "GYAVIRA"
                //$lastName = $nameArray[1]; 
                
                wagonjwa::create([
                    'pat_no'=>$pat_no,
                    'patient_id'=>$patient['patient_identifier'],
                    'sample_id'=>$patient['specimen_uuid'],
                    'surname' => $patient['patient_surname'],
                    'given_name' => $patient['patient_firstname'] != '' ? $patient['patient_firstname'] : $given_name,
                    'priority'=>'Normal',
                    'who_tested' => 'Alert',
                    'test_reason' => 'Routine Exposure',
                    'gender' => $patient['sex'] != '' ? $patient['sex'] : 'N/A',
                    'age'=>$patient['age']!= '' ? $patient['age'] : 'N/A',
                    'phone_number'=>$patient['patient_contact'],
                    'nationality' => $patient['nationality'],
                    'patient_district' => $patient['swabing_district'],
                    'swab_district' => $patient['swabing_district'],
                    'collection_date' => $patient['specimen_collection_date'],                    
                    'sample_type' => $patient['sample_type'],
                    'ever_been_positive' =>'No',
                    'ever_been_vaccinated'=>'No',
                    'created_by' => auth()->user()->id,
                    'collected_by' => 245,
                    'entry_type' => 'RDS',
                    'facility_id'=>70
                ]);
                $pat_no='';
                $this->update_status($patient['specimen_uuid']);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Patient claimed and created successfully']);
            });
            // dd('success');
        }else{
            $pat_no='';
            $this->update_status($patient['specimen_uuid']);
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Error',
                'text' => 'Something went wrong!',
            ]);
        }
       
    }

    public function update_status($specimen_uuid)
    {
        $patient= [
            "specimen_uuid"=>$specimen_uuid,
            "lis_id"=>"eyJpdiI6ImVDdDVuNENobUhBSlQrUm9FZjNYc2c9PSIsInZhbHVlIjoiY3VaOStuMkl6S0dQOTVYM01YMWYyQT09IiwibWFjIjoiNzRiNjhkYjM2YWU2YWIzZDJlYTMzZGEwZThmMGVhNWQ3OTVhZjNiZmMxM2NiNGQ5NTMyNWUwNzllOTAzNDM3MSJ9",
            "eac_lab_id"=>"eyJpdiI6Im52a24wSmtyamN0YXd2TTNPejBkN1E9PSIsInZhbHVlIjoiM2pYbEFEYVRldDNtbE1uMjJ4em9JUT09IiwibWFjIjoiZGViOGE2MjM3YWNjZjdkNDNhYTVmMGMzNDc2MDdiMzUxZjRjMGM3NzRhMTdkMzY5N2U4MTQ4NzhlZmFjZjkxYiJ9",
            "status" => true
        ];

        // dd($patient);
        $client = new Client(['base_uri' => 'https://apitest.cphluganda.org/sync/results', 'verify' => false]);
        try {
            $res = $client->request('POST', 'https://apitest.cphluganda.org/sync/results', [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($patient),
            ]);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => $res->getBody()->getContents()]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {           
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => $e->getResponse()->getBody()->getContents()]);
        }
    }
    
    public function render()
    {
        return view('livewire.crs.external-patient-entry');
    }
}
