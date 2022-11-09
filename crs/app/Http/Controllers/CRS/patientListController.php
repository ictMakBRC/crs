<?php

namespace App\Http\Controllers\crs;

use App\Http\Controllers\Controller;
use App\Models\CRS\Facility;
use App\Models\CRS\wagonjwa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class patientListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function pending()
    {
        $sub = '';
        $ac = 'd-none';
        $val = 'd-none';
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'collected')
    ->paginate(500);
        $state = 'collected';
        $time = 'all';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function pending_today()
    {
        $sub = '';
        $ac = 'd-none';
        $val = 'd-none';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'collected')
    ->whereDay('wagonjwas.created_at', '=', $today)
    ->paginate(500);
        $state = 'collected';
        $time = 'today';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function pending_yesterday()
    {
        $sub = '';
        $ac = 'd-none';
        $val = 'd-none';
        $yesterday = Carbon::yesterday();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'collected')
    ->whereDay('wagonjwas.created_at', '=', $yesterday)
    ->paginate(500);
        $state = 'collected';
        $time = 'today';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function pending_this_week()
    {
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'collected')
    ->whereBetween('wagonjwas.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
    ->paginate(500);
        $sub = '';
        $ac = 'd-none';
        $val = 'd-none';
        $state = 'collected';
        $time = 'week';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function pending_this_month()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'collected')
    ->whereMonth('wagonjwas.created_at', '=', $today)
    ->paginate(500);
        $sub = '';
        $ac = 'd-none';
        $val = 'd-none';
        $state = 'collected';
        $time = 'months';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    //=======================================================All Accessioned=============================================
    public function accessioned()
    {
        $patients = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Accessioned')
    ->orderBy('lab_no', 'desc')
    ->paginate(500);
        $sub = 'd-none';
        $ac = '';
        $val = 'd-none';
        $state = 'Accessioned';
        $time = 'all';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function accessioned_today()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('lab_no', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Accessioned')
    ->whereDay('wagonjwas.accessioned_at', '=', $today)
    ->paginate(500);
        $sub = 'd-none';
        $ac = '';
        $val = 'd-none';
        $state = 'Accessioned';
        $time = 'today';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function accessioned_yesterday()
    {
        $sub = '';
        $today = Carbon::now();
        $yesterday = Carbon::yesterday();
        $patients = wagonjwa::orderBy('lab_no', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Accessioned')
    ->whereDay('wagonjwas.accessioned_at', '=', $yesterday)
    ->paginate(500);
        $sub = 'd-none';
        $ac = '';
        $val = 'd-none';
        $state = 'Accessioned';
        $time = 'today';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function accessioned_this_week()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('lab_no', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Accessioned')
    ->whereBetween('wagonjwas.accessioned_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
    ->paginate(500);
        $sub = 'd-none';
        $ac = '';
        $val = 'd-none';
        $state = 'Accessioned';
        $time = 'week';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function accessioned_this_month()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('lab_no', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Accessioned')
    ->whereMonth('wagonjwas.accessioned_at', '=', $today)
    ->paginate(500);
        $sub = 'd-none';
        $ac = '';
        $val = 'd-none';
        $state = 'Accessioned';
        $time = 'months';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function validatedates()
    {
        $patients = wagonjwa::orderBy('lab_no', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Validated')
    ->paginate(500);
        //for HTML DOM display toggle
        $sub = 'd-none';
        $ac = '';
        $val = 'd-none';
        $state = 'Validated';
        $time = 'all';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }
    //=======================================================All validated=============================================

    public function validated()
    {
        $patients = wagonjwa::orderBy('lab_no', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Validated')
    ->paginate(500);
        //for HTML DOM display toggle
        $sub = 'd-none';
        $ac = 'd-none';
        $val = '';
        $state = 'Validated';
        $time = 'all';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function validated_today()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Validated')
    ->whereDay('wagonjwas.entered_at', '=', $today)
    ->orderBy('lab_no', 'desc')
    ->paginate(500);
        $sub = 'd-none';
        $ac = 'd-none';
        $val = '';
        $state = 'Validated';
        $time = 'today';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function validated_yesterday()
    {
        $sub = '';
        $today = Carbon::now();
        $yesterday = Carbon::yesterday();
        $patients = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Validated')
    ->whereDay('wagonjwas.entered_at', '=', $yesterday)
    ->orderBy('lab_no', 'desc')
    ->paginate(500);
        $sub = 'd-none';
        $ac = 'd-none';
        $val = '';
        $state = 'Validated';
        $time = 'today';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function validated_this_week()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('lab_no', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Validated')
    ->whereBetween('wagonjwas.entered_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
    ->paginate(500);
        $sub = 'd-none';
        $ac = 'd-none';
        $val = '';
        $state = 'Validated';
        $time = 'week';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function validated_this_month()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('lab_no', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('status', '=', 'Validated')
    ->whereMonth('wagonjwas.entered_at', '=', $today)
    ->paginate(500);
        $sub = 'd-none';
        $ac = 'd-none';
        $val = '';
        $state = 'Validated';
        $time = 'months';

        return view('crs.labPatientsPending', compact('patients', 'sub', 'ac', 'val', 'state', 'time'));
    }

    public function exportPatient($id)
    {
        $fileName = time().'.csv';
        $Exptasks = wagonjwa::addSelect([
            'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
            'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'),    ]
    )
    ->where('id', $id)
    ->get();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['Lab No', 'Patient ID', 'Collection date', 'Date recieved', 'Facility type', 'Facility name', 'Patient Name', 'Gender', 'Age', 'Nationality', 'Contact', 'Patient District', 'Swab District', 'Test Type', 'WorkSheet No.', 'Result', 'Target', 'CT value',  'Test kit', 'Results Approver'];

        $callback = function () use ($Exptasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($Exptasks as $task) {
                $row['Lab No'] = $task->lab_no;
                $row['Patient ID'] = $task->patient_id;
                $row['Collection date'] = $task->collection_date;
                $row['Date recieved'] = $task->accessioned_at;
                $row['Facility type'] = $task->facility_type;
                $row['Facility name'] = $task->collection_site;
                $row['Patient Name'] = $task->surname.' '.$task->given_name.' '.$task->other_name;
                $row['Gender'] = $task->gender;
                $row['Age'] = $task->age;
                $row['Nationality'] = $task->nationality;
                $row['Contact'] = $task->phone_number;
                $row['Patient District'] = $task->patient_district;
                $row['Swab District'] = $task->swab_district;
                $row['Test Type'] = $task->test_type;
                $row['Worksheet No.'] = $task->test_type;
                $row['Result'] = $task->result;
                $row['CT value'] = $task->ct_value;
                $row['Target'] = $task->ct_value;
                $row['Test kit'] = $task->test_kit;
                $row['Results Approver'] = $task->results_approver_name;

                fputcsv($file, [
                    $row['Lab No'],
                    $row['Patient ID'],
                    $row['Collection date'],
                    $row['Date recieved'],
                    $row['Facility type'],
                    $row['Facility name'],
                    $row['Patient Name'],
                    $row['Gender'],
                    $row['Age'],
                    $row['Nationality'],
                    $row['Contact'],
                    $row['Patient District'],
                    $row['Swab District'],
                    $row['Test Type'],
                    $row['Worksheet No.'],
                    $row['Result'],
                    $row['CT value'],
                    $row['Target'],
                    $row['Test kit'],
                    $row['Results Approver'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPatientAll(Request $request)
    {
        $Exptasks = '';
        $today = Carbon::now();
        $time = $request->input('time');
        $state = $request->input('state');

        if ($time == 'today') {
            $fileName = 'All todays pending patients_'.time().'.csv';
            $Exptasks = wagonjwa::addSelect([
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'), ])
        ->where('status', $state)->whereDay('wagonjwas.date_recieved', '=', $today)->get();

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
        } elseif ($time == 'week') {
            $fileName = 'All Weekly pending patients_'.time().'.csv';
            $Exptasks = wagonjwa::addSelect([
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'), ])
        ->where('status', $state)->whereBetween('wagonjwas.date_recieved', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
        } elseif ($time == 'months') {
            $fileName = 'All Montly pending patients_'.time().'.csv';
            $Exptasks = wagonjwa::addSelect([
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'), ])
        ->where('status', $state)->whereMonth('wagonjwas.date_recieved', '=', $today)->get();

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
        } elseif ($time == 'pending') {
            $fileName = 'All pending patients_'.time().'.csv';
            $Exptasks = wagonjwa::addSelect([
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'), ])
        ->where('status', $state)->get();

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
        } else {
            $fileName = 'All imported results_'.$value.'.csv';
            $time = $value;
            $Exptasks = wagonjwa::addSelect([
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'), ])
            ->where('import_batch', $value)->WhereNotNull('lab_no')->Where('status', 'Completed')
            ->orderBy('wagonjwas.lab_no', 'asc')
            ->get();
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
        }

        $columns = ['Lab No', 'Patient ID', 'Collection date', 'Date recieved', 'Facility type', 'Facility name', 'Patient Name', 'Gender', 'Age', 'Nationality', 'Contact', 'Patient District', 'Swab District', 'Test Type', 'Worksheet No.', 'Result', 'Target', 'CT value',  'Test kit', 'Results Approver'];

        $callback = function () use ($Exptasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($Exptasks as $task) {
                $row['Lab No'] = $task->lab_no;
                $row['Patient ID'] = $task->patient_id;
                $row['Collection date'] = $task->collection_date;
                $row['Date recieved'] = $task->accessioned_at;
                $row['Facility type'] = $task->facility_type;
                $row['Facility name'] = $task->collection_site;
                $row['Patient Name'] = $task->surname.' '.$task->given_name.' '.$task->other_name;
                $row['Gender'] = $task->gender;
                $row['Age'] = $task->age;
                $row['Nationality'] = $task->nationality;
                $row['Contact'] = $task->phone_number;
                $row['Patient District'] = $task->patient_district;
                $row['Swab District'] = $task->swab_district;
                $row['Test Type'] = $task->test_type;
                $row['Worksheet No.'] = $task->test_type;
                $row['Result'] = $task->result;
                $row['CT value'] = $task->ct_value;
                $row['Target'] = $task->ct_value;
                $row['Test kit'] = $task->test_kit;
                $row['Results Approver'] = $task->results_approver_name;

                fputcsv($file, [
                    $row['Lab No'],
                    $row['Patient ID'],
                    $row['Collection date'],
                    $row['Date recieved'],
                    $row['Facility type'],
                    $row['Facility name'],
                    $row['Patient Name'],
                    $row['Gender'],
                    $row['Age'],
                    $row['Nationality'],
                    $row['Contact'],
                    $row['Patient District'],
                    $row['Swab District'],
                    $row['Test Type'],
                    $row['Worksheet No.'],
                    $row['Result'],
                    $row['CT value'],
                    $row['Target'],
                    $row['Test kit'],
                    $row['Results Approver'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPendingResults(Request $request, $value)
    {
        $Exptasks = '';
        $today = Carbon::now();
        $yesterday = Carbon::yesterday();
        $time = $value;

        if ($time == 'today') {
            $fileName = 'All todays pending patients results_'.$today.'.csv';
            $Exptasks = wagonjwa::addSelect([
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'), ])
        ->WhereNull('result')->WhereNotNull('lab_no')->Where('status', 'Validated')
        ->whereDay('wagonjwas.date_recieved', '=', $today)
        ->orderBy('wagonjwas.lab_no', 'asc')->get();

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
        } elseif ($time == 'yesterday') {
            $fileName = 'All yesterdays pending patients results_'.$yesterday.'.csv';
            $Exptasks = wagonjwa::addSelect([
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'), ])
            ->WhereNull('result')->WhereNotNull('lab_no')->Where('status', 'Validated')
            ->whereDay('wagonjwas.created_at', '=', $yesterday)
            ->orderBy('wagonjwas.lab_no', 'asc')
            ->get();

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
        } elseif ($time == 'pending') {
            $fileName = 'All pending patients_'.time().'.csv';
            $Exptasks = wagonjwa::addSelect([
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'), ])
            ->WhereNull('result')->WhereNotNull('lab_no')->Where('status', 'Validated')
            ->orderBy('wagonjwas.lab_no', 'asc')->get();

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
        } else {
            $fileName = 'All imported results_'.$value.'.csv';
            $time = $value;
            $Exptasks = wagonjwa::addSelect([
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'), ])
            ->where('import_batch', $value)->WhereNotNull('lab_no')->Where('status', 'Completed')
            ->orderBy('wagonjwas.lab_no', 'asc')
            ->get();
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
        }

        $columns = ['LabNo',
            'PatientID', 'FacilityName', 'Who',
            'WorkSheet', 'TestType', 'Platform', 'Testkit', 'Result',
            'Target1', 'CTvalue1', 'Target2', 'CTvalue2', 'Target3', 'CTvalue3', 'CollectionDate', ];

        $callback = function () use ($Exptasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($Exptasks as $task) {
                $row['LabNo'] = $task->lab_no;
                $row['PatientID'] = $task->patient_id;
                $row['FacilityName'] = $task->collection_site;
                $row['Who'] = $task->who_tested;
                $row['WorkSheet'] = $task->worksheet_no;
                $row['TestType'] = 'RT qPCR';
                $row['Platform'] = $task->platform;
                $row['Testkit'] = $task->test_kit;
                $row['Result'] = $task->result;
                $row['Target1'] = $task->target1;
                $row['CTvalue1'] = $task->ct_value;
                $row['Target2'] = $task->target2;
                $row['CTvalue2'] = $task->ct_value2;
                $row['Target3'] = $task->target3;
                $row['CTvalue3'] = $task->ct_value3;
                $row['CollectionDate'] = $task->collection_date;

                fputcsv($file, [
                    $row['LabNo'],
                    $row['PatientID'],
                    $row['FacilityName'],
                    $row['Who'],
                    $row['WorkSheet'],
                    $row['TestType'],
                    $row['Platform'],
                    $row['Testkit'],
                    $row['Result'],
                    $row['Target1'],
                    $row['CTvalue1'],
                    $row['Target2'],
                    $row['CTvalue2'],
                    $row['Target3'],
                    $row['CTvalue3'],
                    $row['CollectionDate'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
