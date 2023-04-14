<?php

namespace App\Http\Livewire\Crs;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\CRS\wagonjwa;
use Illuminate\Support\Facades\DB;

class ExternalPatientEntry extends Component
{
    public $external_patients;
    public $referred = false;
    public function mount()
    {
       
           
           
    }

  

    public function claimPatient($specimen_identifier)
    {
        $patient=$this->external_patients->where('specimen_identifier',$specimen_identifier)->first();
        $patNumber = Wagonjwa::where('patient_id',$patient['specimen_identifier'])->value('patient_id');
        $latestPatNo = Wagonjwa::select('pat_no')->whereNotNull('pat_no')->orderBy('id', 'desc')->first();
        //$count=Wagonjwa::count();
        if ($latestPatNo) {
            $pat_no = 'BRC-'.(substr(explode('-', $latestPatNo->pat_no)[1], 0, -1) + 1).'P';
        } else {
            $pat_no = 'BRC-10000P';
        }

        // dd($patNumber);
        // dd($patient);
        if($patient &&  $patient['specimen_uuid']!='' && $patNumber==null){
            DB::transaction(function () use($patient,$pat_no){
                //  dd($patient);

                $fullName = $patient['patient_surname'];
                $nameArray = explode(" ", $fullName);

                $given_name = $nameArray[0]; // "GYAVIRA"
                //$lastName = $nameArray[1]; 
                
                wagonjwa::create([
                    'pat_no'=>$pat_no,
                    'patient_id'=>$patient['patient_identifier']!= '' ? $patient['patient_identifier'] : $patient['specimen_identifier'],
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
                // $this->update_status($patient['specimen_uuid']);
                $this->RESTRACK($patient['specimen_identifier']);
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
            // "lis_id"=>"eyJpdiI6ImVDdDVuNENobUhBSlQrUm9FZjNYc2c9PSIsInZhbHVlIjoiY3VaOStuMkl6S0dQOTVYM01YMWYyQT09IiwibWFjIjoiNzRiNjhkYjM2YWU2YWIzZDJlYTMzZGEwZThmMGVhNWQ3OTVhZjNiZmMxM2NiNGQ5NTMyNWUwNzllOTAzNDM3MSJ9",
            // "eac_lab_id"=>"eyJpdiI6Im52a24wSmtyamN0YXd2TTNPejBkN1E9PSIsInZhbHVlIjoiM2pYbEFEYVRldDNtbE1uMjJ4em9JUT09IiwibWFjIjoiZGViOGE2MjM3YWNjZjdkNDNhYTVmMGMzNDc2MDdiMzUxZjRjMGM3NzRhMTdkMzY5N2U4MTQ4NzhlZmFjZjkxYiJ9",
            'lis_id' => 'eyJpdiI6IlZxbXBoN3BWSFBUTjdXaW1QeE83NHc9PSIsInZhbHVlIjoiYmd3S3FkQ2MxTGIrUWExSnJsbXc2dz09IiwibWFjIjoiYjk2MDRjNjU4MDIxMmJlY2U2OGM4ZGVlODhmZjNkOTQ2NDU4NGJlNjk4OGE2NGI5OTI4ZDdlZWYxODExMjdhMyJ9',
            'eac_lab_id' => 'eyJpdiI6IklYR1Exb3M5UjRSYzN5SjlSa1ZjNWc9PSIsInZhbHVlIjoiV1pBSHNsdURyaGp4cEJYR0t3V0t3QT09IiwibWFjIjoiMWY3NDM1N2E4MmQxMTU2OTk4ZjIwMGQ2MDUxNzViMGRhZjY1ZDg4NjE3Y2IyZDYxMWQzMDdlMTU1NjE5Yzg2ZiJ9',
            "status" => true
        ];

        // dd($patient);
        $client = new Client(['base_uri' => 'https://limsapi.cphluganda.org/receive/samples', 'verify' => false]);
        try {
            $res = $client->request('POST', 'https://limsapi.cphluganda.org/receive/samples', [
                'headers' => ['Content-Type' => 'application/json'],
                'auth' => [ 'maklims', 'm@kl!m5.' ],
                'body' => json_encode($patient),
            ]);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => $res->getBody()->getContents()]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {           
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => $e->getResponse()->getBody()->getContents()]);
        }

       
    }

    public function RESTRACK($specimen_identifier)
    {
        $patient1= [
            "sample_identifier"=>$specimen_identifier,           
            'ref_lab_id' => 'Y3K5vv9cdJ7',
            "receipt_date" => date('Y-m-d')
        ];
        // dd($patient1);
        $client1 = new Client(['base_uri' => 'https://homtest.cphluganda.org/api/restrack/receive_sample/', 'verify' => false]);
        try {
            $res1 = $client1->request('POST', 'https://homtest.cphluganda.org/api/restrack/receive_sample/', [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($patient1),
            ]);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => $res1->getBody()->getContents()]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {           
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => $e->getResponse()->getBody()->getContents()]);
        }
    }
    
    public function render()
    {
        $client = new Client(['base_uri' => 'https://limsapi.cphluganda.org/covid_suspects', 'verify' => false]);
        try {
        if($this->referred){
            $res = $client->request('GET', 'https://limsapi.cphluganda.org/covid_suspects', [
                'auth' => [ 'maklims', 'm@kl!m5.' ],
                // 'auth' => ['uvri_lims', '4B>{jaE54^_azqR['],
               'query' => [
                       'eac_lab_id' => 'eyJpdiI6IklYR1Exb3M5UjRSYzN5SjlSa1ZjNWc9PSIsInZhbHVlIjoiV1pBSHNsdURyaGp4cEJYR0t3V0t3QT09IiwibWFjIjoiMWY3NDM1N2E4MmQxMTU2OTk4ZjIwMGQ2MDUxNzViMGRhZjY1ZDg4NjE3Y2IyZDYxMWQzMDdlMTU1NjE5Yzg2ZiJ9',
                       'status' => 'referred',]
           ]);
        }else{
            $res = $client->request('GET', 'https://limsapi.cphluganda.org/covid_suspects',[
                'auth' => [ 'maklims', 'm@kl!m5.' ]
                // 'auth' => ['uvri_lims', '4B>{jaE54^_azqR[']
            ]); 
        }
            $data = collect(json_decode($res->getBody(), true));
            $this->external_patients=$data;
            
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->external_patients = collect([]);
        }

        return view('livewire.crs.external-patient-entry');
    }
}
