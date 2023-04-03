<?php

namespace App\Http\Controllers\crs;

use App\Http\Controllers\Controller;
use App\Models\CRS\Facility;
use App\Models\CRS\Platform;
use App\Models\CRS\Swabber;
use App\Models\CRS\wagonjwa;
use App\Models\User;
use App\Models\CRS\Tat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $parents = Facility::with('parent')->orderBy('facility_name', 'desc')->whereNull('parent_id')->get();
        $facilities = Facility::with('parent')->orderBy('facility_name', 'desc')->get();
        $users = User::all();
        $platforms = Platform::all();

        return view('crs.labFilterPatients', compact('facilities', 'users', 'parents', 'platforms'));
    }

    public function filterPatients()
    {
        $parents = Facility::with('parent')->orderBy('facility_name', 'desc')->whereNull('parent_id')->get();
        $facilities = Facility::with('parent')->orderBy('facility_name', 'desc')->get();
        $users = User::all();
        $platforms = Platform::all();
        $swabbers = Swabber::all();

        return view('crs.labReportFilterPatients', compact('facilities', 'users', 'parents', 'platforms', 'swabbers'));
    }

    public function filterPatientsresults(Request $request)
    {
        $from = Carbon::parse($request->input('from'))->toDateTimeString();
        $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();
        if ($request->facility_ex != '0') {
            $request->facility_id = 'all';
        }
        if ($request->entered_ex != '0') {
            $request->entered_by = 'all';
        }
        if ($request->swabber_ex != '0') {
            $request->swabber_in = 'all';
        }
        if ($request->platform_ex != '0') {
            $request->platform = 'all';
        }
        $Exptasks = wagonjwa::orderBy('facilities.id', 'desc')
         ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')        
         ->select('*', 'wagonjwas.id as wid', 'wagonjwas.surname as patientName')
         ->leftJoin('platforms', 'wagonjwas.platform', '=', 'platforms.id')
         ->leftJoin('swabbers', 'wagonjwas.collected_by', '=', 'swabbers.id')
         ->leftJoin('users', 'wagonjwas.created_by', '=', 'users.id')
         ->whereBetween('wagonjwas.created_at', [$from, $to])
         ->when($request->facility_id != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.facility_id', $request->facility_id);
         })
         ->when($request->facility_ex != '0', function ($query) use ($request) {
             $query->where('wagonjwas.facility_id', '!=', $request->facility_ex);
         })
         ->when($request->entered_by != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.created_by', $request->entered_by);
         })
         ->when($request->entered_ex != '0', function ($query) use ($request) {
             $query->where('wagonjwas.created_by', '!=', $request->entered_ex);
         })
         ->when($request->swabber_in != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.collected_by', $request->swabber_in);
         })
         ->when($request->swabber_ex != '0', function ($query) use ($request) {
             $query->where('wagonjwas.collected_by', '!=', $request->swabber_ex);
         })
         ->when($request->platform != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.platform', $request->platform);
         })
         ->when($request->platform_ex != '0', function ($query) use ($request) {
             $query->where('wagonjwas.platform', '!=', $request->platform_ex);
         })
         ->when($request->result != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.result', $request->result);
         })->get();
        $fileName = 'All.csv';
        $facility = 'All.csv';
        $patients = $Exptasks;

        return $this->export($Exptasks, $fileName);

        return view('crs.labReportPatientList', compact('patients', 'to', 'from', 'facility'));
    }
    public $headrName = 'Date';    
    public function filterPatientsCount(Request $request)
    {
        $from = Carbon::parse($request->input('from'))->toDateTimeString();
        $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();
        if ($request->facility_ex != '0') {
            $request->facility_id = 'all';
        }
        if ($request->entered_ex != '0') {
            $request->entered_by = 'all';
        }
        if ($request->swabber_ex != '0') {
            $request->swabber_in = 'all';
        }
        if ($request->platform_ex != '0') {
            $request->platform = 'all';
        }
        $headrName = 'Date';
        $Exptasks = wagonjwa::whereBetween('wagonjwas.created_at', [$from, $to])
         ->when($request->facility_id != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.facility_id', $request->facility_id);
         })
         ->when($request->facility_ex != '0', function ($query) use ($request) {
             $query->where('wagonjwas.facility_id', '!=', $request->facility_ex);
         })
         ->when($request->entered_by != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.created_by', $request->entered_by);
         })
         ->when($request->entered_ex != '0', function ($query) use ($request) {
             $query->where('wagonjwas.created_by', '!=', $request->entered_ex);
         })
         ->when($request->swabber_in != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.collected_by', $request->swabber_in);
         })
         ->when($request->swabber_ex != '0', function ($query) use ($request) {
             $query->where('wagonjwas.collected_by', '!=', $request->swabber_ex);
         })
         ->when($request->platform != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.platform', $request->platform);
         })
         ->when($request->platform_ex != '0', function ($query) use ($request) {
             $query->where('wagonjwas.platform', '!=', $request->platform_ex);
         })
         ->when($request->result != 'all', function ($query) use ($request) {
             $query->where('wagonjwas.result', $request->result);
         })
         ->when($request->group == 'Daily', function ($query) use ($request) {
            $query->select(DB::raw('count(wagonjwas.id) as `data`'),
            DB::raw("DATE_FORMAT(wagonjwas.created_at, '%Y-%m-%d') DateCreated"))
            ->groupBy('DateCreated')->orderBy('DateCreated', 'DESC');
            $this->headrName = 'Day';
        })
        ->when($request->group == 'Weekly', function ($query) use ($request) {
            $query->select(DB::raw('count(wagonjwas.id) as `data`'),
            DB::raw("DATE_FORMAT(wagonjwas.created_at, '%Y-%w') DateCreated"))
            ->groupBy('DateCreated')->orderBy('DateCreated', 'DESC');
            $this->headrName = 'Week';
        })
        ->when($request->group == 'Monthly', function ($query) use ($request) {
            $query->select(DB::raw('count(wagonjwas.id) as `data`'),
            DB::raw("DATE_FORMAT(wagonjwas.created_at, '%Y-%m') MonthCreated"),
            DB::raw("DATE_FORMAT(wagonjwas.created_at, '%Y-%M') DateCreated"))->groupBy('DateCreated')
            ->orderBy('MonthCreated', 'DESC');           
            $this->headrName = 'Month';
        })
        ->when($request->group == 'Quarterly', function ($query) use ($request) {
            $query->select(DB::raw('count(wagonjwas.id) as `data`'),
            DB::raw('YEAR(wagonjwas.created_at) year, quarter(wagonjwas.created_at) DateCreated'))
            ->groupBy('DateCreated')->groupBy('year')->orderBy('DateCreated', 'DESC');
            $this->headrName = 'Quarter';
        })
        ->when($request->group == 'Yearly', function ($query) use ($request) {
            $query->select(DB::raw('count(wagonjwas.id) as `data`'),
            DB::raw("DATE_FORMAT(wagonjwas.created_at, '%Y') DateCreated"))
            ->groupBy('DateCreated')->orderBy('DateCreated', 'DESC');           
            $this->headrName = 'Year';
        })
        ->get();
        $fileName = 'All '.$this->headrName. 'ly sample data.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [$this->headrName, 'Total_Samples'];
        $callback = function () use ($Exptasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($Exptasks as $task) {
                $row['DateCreated'] = $task->DateCreated;
                $row['Total'] = $task->data;
                
                fputcsv($file, [
                    $row['DateCreated'],
                    $row['Total'],
                  
                ]);
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);

        return view('crs.labReportPatientList', compact('patients', 'to', 'from', 'facility'));
    }

    public function Avgtat(Request $request)
    {
        $from = Carbon::parse($request->input('from'))->toDateTimeString();
        $to = Carbon::parse($request->input('to'))->addHour(23)->toDateTimeString();
        $fileName = 'Avg Daily TAT.csv';
        $headrName = 'DateCreated';
        $Exptasks = DB::select(DB::raw('SELECT  DateCreated AS Createdat, 
                                        AVG(EntryToReceipt) AS EntryToReceipt, 
                                        AVG(ReceiptToVerification) AS ReceiptToVerification, 
                                        AVG(VerificationToResult) AS VerificationToResult, 
                                        AVG(ReceiptToResult) AS ReceiptToResult, 
                                        AVG(EntryToResult) AS EntryToResult
                                        FROM TAT_Per_Entry GROUP BY DateCreated
                                        ORDER BY DateCreated DESC'));
     return $this->tatExport($Exptasks, $fileName, $headrName);
    }
    public function AvgMonthlytat(Request $request)
    {
        $fileName = 'Avg Monthly TAT.csv';
        $headrName = 'MonthCreated';
        $Exptasks = DB::select(DB::raw('SELECT  MonthCreated AS Createdat, 
                                        AVG(EntryToReceipt) AS EntryToReceipt, 
                                        AVG(ReceiptToVerification) AS ReceiptToVerification, 
                                        AVG(VerificationToResult) AS VerificationToResult, 
                                        AVG(ReceiptToResult) AS ReceiptToResult, 
                                        AVG(EntryToResult) AS EntryToResult
                                        FROM TAT_Per_Entry GROUP BY MonthCreated ORDER BY Createdat DESC'));
     return $this->tatExport($Exptasks, $fileName, $headrName);
    }

    public function AvgQuartertat(Request $request)
    {
        $fileName = 'Avg Quarterly TAT.csv';
        $headrName = 'QuarterCreated';
        $Exptasks = DB::select(DB::raw('SELECT YearCreated,  Myquarter AS Createdat, 
                                        AVG(EntryToReceipt) AS EntryToReceipt, 
                                        AVG(ReceiptToVerification) AS ReceiptToVerification, 
                                        AVG(VerificationToResult) AS VerificationToResult, 
                                        AVG(ReceiptToResult) AS ReceiptToResult, 
                                        AVG(EntryToResult) AS EntryToResult
                                        FROM TAT_Per_Entry GROUP BY Myquarter, YearCreated
                                        ORDER BY YearCreated ASC, Myquarter ASC'));
     return $this->tatExport($Exptasks, $fileName, $headrName);
    }

    public function tatExport($Exptasks, $fileName, $headrName){
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [$headrName, 'EntryToReceipt', 'ReceiptToVerification', 'VerificationToResult', 'ReceiptToResult', 'EntryToResult'];
        $callback = function () use ($Exptasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($Exptasks as $task) {
                $row['DateCreated'] = $task->Createdat;
                $row['EntryToReceipt'] = $task->EntryToReceipt;
                $row['ReceiptToVerification'] = $task->ReceiptToVerification;
                $row['VerificationToResult'] = $task->VerificationToResult;
                $row['ReceiptToResult'] = $task->ReceiptToResult;
                $row['EntryToResult'] = $task->EntryToResult;

                fputcsv($file, [
                    $row['DateCreated'],
                    $row['EntryToReceipt'],
                    $row['ReceiptToVerification'],
                    $row['VerificationToResult'],
                    $row['ReceiptToResult'],
                    $row['EntryToResult'],
                ]);
            }

            fclose($file);
        };
        // DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return response()->stream($callback, 200, $headers);
        //  return view('crs.labReportTatList',compact('time_difference','to','from'));
    }
    public function AvgtatSingle(Request $request)
    {
        $from = Carbon::parse($request->input('from'))->toDateTimeString();
        $to = Carbon::parse($request->input('to'))->addHour(23)->toDateTimeString();
        $fileName = 'Avg Patient TAT.csv';
        $Exptasks = DB::select(DB::raw('SELECT  LabNo, PatientNo, DateCreated, 
                                                         EntryToReceipt, 
                                                         ReceiptToVerification, 
                                                         VerificationToResult, 
                                                         ReceiptToResult, 
                                                        EntryToResult
                                                        FROM TAT_Per_Entry
                                                        ORDER BY DateCreated DESC'));
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        $columns = ['LabNo', 'PatientNo', 'DateCreated', 'EntryToReceipt', 'ReceiptToVerification', 'VerificationToResult', 'ReceiptToResult', 'EntryToResult'];
        $callback = function () use ($Exptasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($Exptasks as $task) {
                $row['LabNo'] = $task->LabNo;
                $row['PatientNo'] = $task->PatientNo;
                $row['DateCreated'] = $task->DateCreated;
                $row['EntryToReceipt'] = $task->EntryToReceipt;
                $row['ReceiptToVerification'] = $task->ReceiptToVerification;
                $row['VerificationToResult'] = $task->VerificationToResult;
                $row['ReceiptToResult'] = $task->ReceiptToResult;
                $row['EntryToResult'] = $task->EntryToResult;

                fputcsv($file, [
                    $row['LabNo'],
                    $row['PatientNo'],
                    $row['DateCreated'],
                    $row['EntryToReceipt'],
                    $row['ReceiptToVerification'],
                    $row['VerificationToResult'],
                    $row['ReceiptToResult'],
                    $row['EntryToResult'],
                ]);
            }

            fclose($file);
        };
        // DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return response()->stream($callback, 200, $headers);
        //  return view('crs.labReportTatList',compact('time_difference','to','from'));
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'q', ]);
        $search = $request->input('q');
        $patients = wagonjwa::orderBy('surname', 'asc')
        ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
        ->select('*', 'wagonjwas.id as wid')
        ->where('patient_id', $search)
        ->orWhere('lab_no', $search)
        ->orWhere('surname', 'LIKE', '%'.$search.'%')
        ->orWhere('given_name', 'LIKE', '%'.$search.'%')
        ->orWhere('other_name', 'LIKE', '%'.$search.'%')
        ->paginate(5);

        return view('crs.labSearchResults', compact('patients', 'search'));
    }

    public function LabfacilityPatients(Request $request)
    {
        if ($request->input('facility_id') != 'all') {
            $today = Carbon::now();
            $from = Carbon::parse($request->input('from'))->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();
            $facility = $request->input('facility_id');
            $patients = wagonjwa::orderBy('facilities.id', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->whereBetween('wagonjwas.created_at', [$from, $to])
            ->where('wagonjwas.facility_id', $request->input('facility_id'))
            ->get();
            // $facility = Facility::where('id',$facility)->select('facility_name')->first();
            $facilityt = Facility::with('parent')->where('id', $facility)->first();
            // foreach($facilityname as $data)
            // {
            // $monthptv = $data->qty;

            // }
            $facility = $facilityt->parent ? $facilityt->facility_name.'('.$facilityt->parent->facility_name.')' : $facilityt->facility_name;

            return view('crs.labReportPatientList', compact('patients', 'to', 'from', 'facility'));
        } else {
            $today = Carbon::now();
            $from = Carbon::parse($request->input('from'))
                ->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)
                ->toDateTimeString();
            $patients = wagonjwa::orderBy('facilities.id', 'desc')
                ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
                ->select('*', 'wagonjwas.id as wid')
                ->whereBetween('wagonjwas.created_at', [$from, $to])
                ->get();
            $facility = 'All';

            return view('crs.labReportPatientList', compact('patients', 'to', 'from', 'facility'));
        }
    }

    public function LabfacilityPatientsCount(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        if ($request->input('facility_id') != 'all') {
            $today = Carbon::now();
            $from = Carbon::parse($request->input('from'))->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();
            $facility = $request->input('facility_id');
            $patients = wagonjwa::orderBy('facilities.facility_name', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
             ->with('facility', 'facility.parent')
                ->select('*', DB::raw('count(wagonjwas.id) as `data`'),
                    DB::raw("count(case when result = 'Positive' then 1 end) as positives"),
                    DB::raw("count(case when result = 'Positive' then 1 end) / count(*) * 100 AS rate"),
                    DB::raw("DATE_FORMAT(wagonjwas.created_at, '%M-%Y') as newdate"), 'facility_name')
                ->groupBy('newdate')
            ->whereBetween('wagonjwas.created_at', [$from, $to])
            ->where('wagonjwas.facility_id', $request->input('facility_id'))
            ->get();
            // $facility = Facility::where('id',$facility)->select('facility_name')->first();
            $facilityt = Facility::with('parent')->where('id', $facility)->first();
            $facility = $facilityt->parent ? $facilityt->facility_name.'('.$facilityt->parent->facility_name.')' : $facilityt->facility_name;

            return view('crs.labReportPatientCount', compact('patients', 'to', 'from', 'facility'));
        } else {
            $today = Carbon::now();
            $from = Carbon::parse($request->input('from'))
                ->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)
                ->toDateTimeString();
            $patients = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->with('facility', 'facility.parent')
                ->select('*', DB::raw('count(wagonjwas.id) as `data`'),
                    DB::raw("count(case when result = 'Positive' then 1 end) as positives"),
                    DB::raw("count(case when result = 'Positive' then 1 end) / count(*) * 100 AS rate"),
                    DB::raw("DATE_FORMAT(wagonjwas.created_at, '%M-%Y') as newdate"), 'facility_name')
                ->groupBy('facilities.id', 'newdate')
                ->whereBetween('wagonjwas.created_at', [$from, $to])
                ->orderBy('facilities.id', 'desc')
                ->get();
            $facility = 'All';

            return view('crs.labReportPatientCount', compact('patients', 'to', 'from', 'facility'));
        }
    }

    public function LabUserEntries(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        if ($request->input('user_id') != 'all') {
            $today = Carbon::now();
            $from = Carbon::parse($request->input('from'))->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();
            $user = $request->input('user_id');
            $patients = wagonjwa::leftJoin('users', 'wagonjwas.created_by', '=', 'users.id')->orderBy('users.id', 'asc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid', 'wagonjwas.surname as Sname', 'wagonjwas.given_name as Gname', 'wagonjwas.other_name as Oname')
            ->whereBetween('wagonjwas.created_at', [$from, $to])
            ->where('wagonjwas.created_by', $request->input('user_id'))
            ->get();
            $user = User::where('id', $user)->select('first_name')->first();
            $user = $user->first_name;

            return view('crs.labReportEntries', compact('patients', 'to', 'from', 'user'));
        } else {
            $today = Carbon::now();
            $from = Carbon::parse($request->input('from'))
                ->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();
            $patients = wagonjwa::leftJoin('users', 'wagonjwas.created_by', '=', 'users.id')->orderBy('users.id', 'asc')
                ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
                ->select('*', 'wagonjwas.id as wid', 'wagonjwas.surname as Sname', 'wagonjwas.given_name as Gname', 'wagonjwas.other_name as Oname')
                ->whereBetween('wagonjwas.created_at', [$from, $to])
                ->get();
            $user = 'All';

            return view('crs.labReportEntries', compact('patients', 'to', 'from', 'user'));
        }
    }

       public function LabSwabberEntries(Request $request)
       {
           DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

           $today = Carbon::now();
           $from = Carbon::parse($request->input('from'))->toDateTimeString();
           $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();
           $user = $request->input('user_id');
           $patients = wagonjwa::leftJoin('users', 'wagonjwas.created_by', '=', 'users.id')->orderBy('users.id', 'asc')
           ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
           ->select('*', 'wagonjwas.id as wid', 'wagonjwas.surname as Sname', 'wagonjwas.given_name as Gname', 'wagonjwas.other_name as Oname')
           ->whereBetween('wagonjwas.created_at', [$from, $to])
           ->where('wagonjwas.created_by', $request->input('user_id'))
           ->get();
           $user = User::where('id', $user)->select('first_name')->first();
           $user = $user->first_name;

           return view('crs.labReportEntries', compact('patients', 'to', 'from', 'user'));
       }

    public function LabUserEntryCount(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        if ($request->input('user_id') != 'all') {
            $today = Carbon::now();
            $from = Carbon::parse($request->input('from'))->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();
            $facility = $request->input('facility_id');
            $patients = wagonjwa::leftJoin('users', 'wagonjwas.created_by', '=', 'users.id')->orderBy('users.id', 'asc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select(DB::raw('count(wagonjwas.id) as `data`'), 'first_name')
            ->whereBetween('wagonjwas.created_at', [$from, $to])
            ->where('wagonjwas.created_by', $request->input('user_id'))
            ->get();
            $user = User::where('id', $user)->select('first_name')->first();
            $user = $user->first_name;

            return view('crs.labReportEntries', compact('patients', 'to', 'from', 'user'));
        } else {
            $today = Carbon::now();
            $from = Carbon::parse($request->input('from'))
                ->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();
            $patients = wagonjwa::leftJoin('users', 'wagonjwas.created_by', '=', 'users.id')->orderBy('users.id', 'asc')
                ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
                ->select(DB::raw('count(wagonjwas.id) as `data`'), 'first_name')
                ->groupBy('users.id')
                ->whereBetween('wagonjwas.created_at', [$from, $to])
                ->get();
            $user = 'All';

            return view('crs.labReportEntryCount', compact('patients', 'to', 'from', 'user'));
        }
    }

    public function moh()
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $fileName = 'All MOH results as per_'.date('Y-m-d H:i').'.csv';
        $Exptasks = DB::select(DB::raw("SELECT   count(*) as total,
        count(case when result = 'Positive' then 1 end) as positives,
        count(case when result = 'Positive' then 1 end) / count(*) * 100 AS percentage,
        DATE_FORMAT(created_at, '%D-%m-%Y') new_date,
        DATE_FORMAT(created_at, '%d/%m/%Y') new_year
        FROM `wagonjwas` WHERE result IS NOT NULL  GROUP BY `new_date` ORDER BY DATE_FORMAT(created_at,'%Y-%m-%d') DESC"));

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        $columns = ['Date Recieved', 'Total Tests', 'Positives', 'Positivity Rate'];
        $callback = function () use ($Exptasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($Exptasks as $task) {
                $row['Date Recieved'] = $task->new_date;
                $row['Total Tests'] = $task->total;
                $row['Positives'] = $task->positives;
                $row['Rate'] = $task->percentage;

                fputcsv($file, [
                    $row['Date Recieved'],
                    $row['Total Tests'],
                    $row['Positives'],
                    $row['Rate'],
                ]);
            }

            fclose($file);
        };
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");

        return response()->stream($callback, 200, $headers);
    }

    public function parentList(Request $request)
    {
        $facility = $request->input('facility_id');
        $facilityName = Facility::where('id', $facility)->select('facility_name')->first();
        $fname = $facilityName->facility_name;
        $fileName = 'All '.$fname.' samples between '.$request->input('from').' and '.$request->input('to').'.csv';
        $from = Carbon::parse($request->input('from'))->toDateTimeString();
        $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();

        $Exptasks1 = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
                ->select('*', 'wagonjwas.id as wid')
                ->where('facilities.id', $facility)
                ->whereBetween('wagonjwas.created_at', [$from, $to])
                ->with('facility', 'facility.parent')
                ->get();

        $Exptasks2 = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
                ->select('*', 'wagonjwas.id as wid')
                ->where('facilities.parent_id', $facility)
                ->orderBy('facility_name', 'asc')
                ->whereBetween('wagonjwas.created_at', [$from, $to])
                ->with('facility', 'facility.parent')
                ->get();

        $collection = new Collection([$Exptasks1, $Exptasks2]);
        $Exptasks = $collection->collapse();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['PTID', 'LabNo', 'BatchNo', 'CollectionDate', 'DateRecieved', 'FacilityName', 'PatientName', 'Gender', 'PatientContact', 'Age', 'Nationality', 'Patient District', 'Swab District', 'WorkSheet No.', 'Result', 'ResultDate', 'Passport',  'TestReason', 'Who', 'VaccineType', 'Sample Type'];

        $callback = function () use ($Exptasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($Exptasks as $task) {
                $row['PTID'] = $task->pat_no;
                $row['Lab No'] = $task->lab_no;
                $row['Patient ID'] = $task->patient_id;
                $row['Collection date'] = $task->collection_date;
                $row['Date recieved'] = $task->accessioned_at;
                $row['Facility name'] = $task->facility_name;
                $row['Patient Name'] = $task->surname.' '.$task->given_name.' '.$task->other_name;
                $row['Gender'] = $task->gender;
                $row['Contact'] = $task->phone_number;
                $row['Age'] = $task->age;
                $row['Nationality'] = $task->nationality;
                $row['Patient District'] = $task->patient_district;
                $row['Swab District'] = $task->swab_district;
                $row['Worksheet No.'] = $task->worksheet_no;
                $row['Result'] = $task->result;
                $row['resultDate'] = $task->result_added_at;
                $row['Passport'] = $task->doc_no;
                $row['TestReason'] = $task->test_reason;
                $row['Who'] = $task->who_tested;
                $row['vaccinetype'] = $task->vaccine_dose1;
                $row['SampleType'] = $task->sample_type;

                fputcsv($file, [
                    $row['PTID'],
                    $row['Lab No'],
                    $row['Patient ID'],
                    $row['Collection date'],
                    $row['Date recieved'],
                    $row['Facility name'],
                    $row['Patient Name'],
                    $row['Gender'],
                    $row['Contact'],
                    $row['Age'],
                    $row['Nationality'],
                    $row['Patient District'],
                    $row['Swab District'],
                    $row['Worksheet No.'],
                    $row['Result'],
                    $row['resultDate'],
                    $row['Passport'],
                    $row['TestReason'],
                    $row['Who'],
                    $row['vaccinetype'],
                    $row['SampleType'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function patientresults(Request $request)
    {
        if ($request->input('result') != 'all') {
            $result = $request->input('result');
            $fileName = 'All '.$result.' samples between '.$request->input('from').' and '.$request->input('to').'.csv';
            $from = Carbon::parse($request->input('from'))->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();

            $Exptasks = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
                    ->leftJoin('platforms', 'wagonjwas.platform', '=', 'platforms.id')
                    ->leftJoin('swabbers', 'wagonjwas.collected_by', '=', 'swabbers.id')
                    ->leftJoin('users', 'wagonjwas.created_by', '=', 'users.id')
                    ->select('*', 'wagonjwas.id as wid', 'wagonjwas.surname as patientName')
                    ->where('wagonjwas.result', $result)
                    ->whereBetween('wagonjwas.created_at', [$from, $to])
                    ->get();
        } else {
            $fileName = 'All patient list samples between '.$request->input('from').' and '.$request->input('to').'.csv';
            $from = Carbon::parse($request->input('from'))->toDateTimeString();
            $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();

            $Exptasks = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->leftJoin('platforms', 'wagonjwas.platform', '=', 'platforms.id')
            ->leftJoin('swabbers', 'wagonjwas.collected_by', '=', 'swabbers.id')
            ->leftJoin('users', 'wagonjwas.created_by', '=', 'users.id')
                    ->select('*', 'wagonjwas.id as wid', 'wagonjwas.surname as patientName')
                    ->whereBetween('wagonjwas.created_at', [$from, $to])
                    ->get();
        }

        return $this->export($Exptasks, $fileName);
    }

     public function platiform(Request $request)
     {
         $result = $request->input('platform');
         $platform = Platform::where('id', $result)->first();
         $fileName = 'All '.$platform->platform_name.' samples between '.$request->input('from').' and '.$request->input('to').'.csv';
         $from = Carbon::parse($request->input('from'))->toDateTimeString();
         $to = Carbon::parse($request->input('to'))->addHour(23)->addMinutes(59)->toDateTimeString();

         $Exptasks = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
                ->leftJoin('platforms', 'wagonjwas.platform', '=', 'platforms.id')
                ->leftJoin('swabbers', 'wagonjwas.collected_by', '=', 'swabbers.id')
                ->leftJoin('users', 'wagonjwas.created_by', '=', 'users.id')
                ->select('*', 'wagonjwas.id as wid', 'wagonjwas.surname as patientName')
                 ->where('wagonjwas.platform', $result)
                 ->whereBetween('wagonjwas.created_at', [$from, $to])
                 ->get();

         return $this->export($Exptasks, $fileName);
     }

     public function export($Exptasks, $fileName)
     {
         $headers = [
             'Content-type' => 'text/csv',
             'Content-Disposition' => "attachment; filename=$fileName",
             'Pragma' => 'no-cache',
             'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
             'Expires' => '0',
         ];

         $columns = ['PTID', 'LabNo', 'BatchNo', 'CollectionDate', 'DateRecieved', 'FacilityName', 'PatientName', 'Gender', 'PatientContact', 'Age', 'Patient District', 'Swab District', 'Swabbed By', 'Entered By', 'WorkSheet No.', 'Result', 'ResultDate', 'Passport',  'TestReason', 'Who', 'Platform_name', 'Targets','Vaccine_Doses','Sample_Type'];

         $callback = function () use ($Exptasks, $columns) {
             $file = fopen('php://output', 'w');
             fputcsv($file, $columns);

             foreach ($Exptasks as $task) {
                 $row['PTID'] = $task->pat_no;
                 $row['Lab No'] = $task->lab_no;
                 $row['Patient ID'] = $task->patient_id;
                 $row['Collection date'] = $task->collection_date;
                 $row['Date recieved'] = $task->accessioned_at;
                 $row['Facility name'] = $task->facility_name;
                 $row['Patient Name'] = $task->patientName.' '.$task->given_name.' '.$task->other_name;
                 $row['Gender'] = $task->gender;
                 $row['Contact'] = $task->phone_number;
                 $row['Age'] = $task->age;
                 $row['Patient District'] = $task->patient_district;
                 $row['Swab District'] = $task->swab_district;
                 $row['Swabbed By'] = $task->full_name;
                 $row['Entered By'] = $task->first_name.' '.$task->name;
                 $row['Worksheet No.'] = $task->worksheet_no;
                 $row['Result'] = $task->result;
                 $row['resultDate'] = $task->result_added_at;
                 $row['Passport'] = $task->doc_no;
                 $row['TestReason'] = $task->test_reason;
                 $row['Who'] = $task->who_tested;
                 $row['PlatformName'] = $task->platform_name;
                 $row['Targets'] = $task->target1.' '.$task->ct_value.' '.$task->target2.' '.$task->ct_value2.' '.$task->target3.' '.$task->ct_value3;
                 $row['Doses'] = $task->vaccine_dose1.' '.$task->vaccine_dose2.' '.$task->vaccine_dose3;
                 $row['Sampletype'] = $task->sample_type;
                 fputcsv($file, [
                     $row['PTID'],
                     $row['Lab No'],
                     $row['Patient ID'],
                     $row['Collection date'],
                     $row['Date recieved'],
                     $row['Facility name'],
                     $row['Patient Name'],
                     $row['Gender'],
                     $row['Contact'],
                     $row['Age'],
                     $row['Patient District'],
                     $row['Swab District'],
                     $row['Swabbed By'],
                     $row['Entered By'],
                     $row['Worksheet No.'],
                     $row['Result'],
                     $row['resultDate'],
                     $row['Passport'],
                     $row['TestReason'],
                     $row['Who'],
                     $row['PlatformName'],
                     $row['Targets'],
                     $row['Doses'],
                     $row['Sampletype'],
                 ]);
             }

             fclose($file);
         };

         return response()->stream($callback, 200, $headers);
     }
     
     
    public function tatMean(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $fileName = 'Avg Monthly TAT.csv';
        $headrName = 'MonthCreated';
        $year = date('Y', strtotime($request->input('date_added')));
        $week = date('Y-M-W', strtotime($request->input('date_added')));
        $month = date('M-Y', strtotime($request->input('date_added')));

       
        $data['meanDailyTat'] = Tat::whereNotNull('result')
        ->when($request->group == null, function ($query) use ($request) {
            $query->select(DB::raw('sum(ReceiptToResult) as `TotalPerDay`'), 
            DB::raw('count(ReceiptToResult) as `CountPerDay`'),
            DB::raw("DATE_FORMAT(DateCreated, '%Y-%m-%d') new_date"))
            ->groupBy('new_date')->orderBy('new_date', 'DESC');
        })
        ->when($request->group == 'Weekly', function ($query) use ($request) {
            $query->select('WeekCreated as new_date',DB::raw('sum(ReceiptToResult) as `TotalPerDay`'), 
            DB::raw('count(ReceiptToResult) as `CountPerDay`'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })
        ->when($request->group == 'Monthly', function ($query) use ($request) {
            $query->select('MonthCreated as new_date',DB::raw('sum(ReceiptToResult) as `TotalPerDay`'), 
            DB::raw('count(ReceiptToResult) as `CountPerDay`'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($request->group == 'Yearly', function ($query) use ($request) {
            $query->select('YearCreated as new_date',DB::raw('sum(ReceiptToResult) as `TotalPerDay`'), 
            DB::raw('count(ReceiptToResult) as `CountPerDay`'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();

        $data['meanData'] = Tat::whereNotNull('result')->limit(12)
        ->when($request->group == null, function ($query) use ($request) {
            $query->select(DB::raw('sum(ReceiptToResult) as `TotalPerDay`'), 
            DB::raw('count(ReceiptToResult) as `CountPerDay`'),
            DB::raw("DATE_FORMAT(DateCreated, '%Y-%m-%d') new_date"))
            ->groupBy('new_date')->orderBy('new_date', 'DESC');
        })
        ->when($request->group == 'Weekly', function ($query) use ($request) {
            $query->select('WeekCreated as new_date',DB::raw('sum(ReceiptToResult) as `TotalPerDay`'), 
            DB::raw('count(ReceiptToResult) as `CountPerDay`'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })
        ->when($request->group == 'Monthly', function ($query) use ($request) {
            $query->select('MonthCreated as new_date',DB::raw('sum(ReceiptToResult) as `TotalPerDay`'), 
            DB::raw('count(ReceiptToResult) as `CountPerDay`'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($request->group == 'Yearly', function ($query) use ($request) {
            $query->select('YearCreated as new_date',DB::raw('sum(ReceiptToResult) as `TotalPerDay`'), 
            DB::raw('count(ReceiptToResult) as `CountPerDay`'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();

      

  
        $data['title']=$request->group!= '' ? $request->group : 'Daily';
    
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('crs.labReportTAT', $data);
    }

    public function tatPropotion(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
     
        if ($request->group == null){
        $data['propotions'] =  DB::select(DB::raw('SELECT DateCreated as new_date, 
            count(*) as total, 
            count(if(ReceiptToResult < 1441, 11, NULL)) as totalwitin, 
            count(if(ReceiptToResult > 1440, 13, NULL)) as totalOut 
            from TAT_Per_Entry WHERE Result IS NOT NULL
            GROUP BY DateCreated
            ORDER BY DateCreated DESC LIMIT 360'));  
        $data['ChartData'] =  DB::select(DB::raw('SELECT DateCreated as new_date, 
            count(*) as total, 
            count(if(ReceiptToResult < 1441, 11, NULL)) as totalwitin, 
            count(if(ReceiptToResult > 1440, 13, NULL)) as totalOut 
            from TAT_Per_Entry WHERE Result IS NOT NULL
            GROUP BY DateCreated
            ORDER BY DateCreated DESC LIMIT 12'));    
        }
        if ($request->group == 'Weekly'){
            $data['propotions'] =  DB::select(DB::raw('SELECT WeekCreated as new_date, 
                count(*) as total, 
                count(if(ReceiptToResult < 1441, 11, NULL)) as totalwitin, 
                count(if(ReceiptToResult > 1440, 13, NULL)) as totalOut 
                from TAT_Per_Entry WHERE Result IS NOT NULL
                GROUP BY WeekCreated
                ORDER BY WeekCreated DESC LIMIT 360'));  
            $data['ChartData'] =  DB::select(DB::raw('SELECT DateCreated as new_date, 
                count(*) as total, 
                count(if(ReceiptToResult < 1441, 11, NULL)) as totalwitin, 
                count(if(ReceiptToResult > 1440, 13, NULL)) as totalOut 
                from TAT_Per_Entry WHERE Result IS NOT NULL
                GROUP BY WeekCreated
                ORDER BY WeekCreated DESC LIMIT 12'));    
            }
            if ($request->group == 'Monthly'){
                $data['propotions'] =  DB::select(DB::raw('SELECT MonthCreated as new_date, 
                    count(*) as total, 
                    count(if(ReceiptToResult < 1441, 11, NULL)) as totalwitin, 
                    count(if(ReceiptToResult > 1440, 13, NULL)) as totalOut 
                    from TAT_Per_Entry WHERE Result IS NOT NULL
                    GROUP BY MonthCreated
                    ORDER BY MonthCreated DESC LIMIT 360'));  
                $data['ChartData'] =  DB::select(DB::raw('SELECT MonthCreated as new_date, 
                    count(*) as total, 
                    count(if(ReceiptToResult < 1441, 11, NULL)) as totalwitin, 
                    count(if(ReceiptToResult > 1440, 13, NULL)) as totalOut 
                    from TAT_Per_Entry WHERE Result IS NOT NULL
                    GROUP BY MonthCreated
                    ORDER BY MonthCreated DESC LIMIT 12'));    
                }
                if ($request->group == 'Yearly'){
                    $data['propotions'] =  DB::select(DB::raw('SELECT YearCreated as new_date, 
                        count(*) as total, 
                        count(if(ReceiptToResult < 1441, 11, NULL)) as totalwitin, 
                        count(if(ReceiptToResult > 1440, 13, NULL)) as totalOut 
                        from TAT_Per_Entry WHERE Result IS NOT NULL
                        GROUP BY YearCreated
                        ORDER BY YearCreated DESC LIMIT 360'));  
                    $data['ChartData'] =  DB::select(DB::raw('SELECT YearCreated as new_date, 
                        count(*) as total, 
                        count(if(ReceiptToResult < 1441, 11, NULL)) as totalwitin, 
                        count(if(ReceiptToResult > 1440, 13, NULL)) as totalOut 
                        from TAT_Per_Entry WHERE Result IS NOT NULL
                        GROUP BY YearCreated
                        ORDER BY YearCreated DESC LIMIT 12'));    
                    }
        $data['title']=$request->group!= '' ? $request->group : 'Daily';
    
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('crs.labReportTatPropotion', $data);
    }

    public function tatRange(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
       

        $data['rangeTat'] =  Tat::whereNotNull('result')
        ->when($request->group == null, function ($query) use ($request) {
            $query->select('DateCreated as new_date',
            DB::raw('MIN(ReceiptToResult) AS MinMins, MAX(ReceiptToResult) AS MaxMins'))
            ->orderBy('DateCreated', 'DESC')->groupBy('DateCreated');
        })
        ->when($request->group == 'Weekly', function ($query) use ($request) {
            $query->select('WeekCreated as new_date',
            DB::raw('MIN(ReceiptToResult) AS MinMins, MAX(ReceiptToResult) AS MaxMins'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })      
        ->when($request->group == 'Monthly', function ($query) use ($request) {
            $query->select('MonthCreated as new_date',
            DB::raw('MIN(ReceiptToResult) AS MinMins, MAX(ReceiptToResult) AS MaxMins'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($request->group == 'Yearly', function ($query) use ($request) {
            $query->select('YearCreated as new_date',
            DB::raw('MIN(ReceiptToResult) AS MinMins, MAX(ReceiptToResult) AS MaxMins'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();

        $data['rangeChartData'] = Tat::whereNotNull('result')->limit(12)
        ->when($request->group == null, function ($query) use ($request) {
            $query->select('DateCreated as new_date',
            DB::raw('MIN(ReceiptToResult) AS MinMins, MAX(ReceiptToResult) AS MaxMins'))
            ->orderBy('DateCreated', 'DESC')->groupBy('DateCreated');
        })
        ->when($request->group == 'Weekly', function ($query) use ($request) {
            $query->select('WeekCreated as new_date',
            DB::raw('MIN(ReceiptToResult) AS MinMins, MAX(ReceiptToResult) AS MaxMins'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })      
        ->when($request->group == 'Monthly', function ($query) use ($request) {
            $query->select('MonthCreated as new_date',
            DB::raw('MIN(ReceiptToResult) AS MinMins, MAX(ReceiptToResult) AS MaxMins'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($request->group == 'Yearly', function ($query) use ($request) {
            $query->select('YearCreated as new_date',
            DB::raw('MIN(ReceiptToResult) AS MinMins, MAX(ReceiptToResult) AS MaxMins'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();    
        $data['title']=$request->group!= '' ? $request->group : 'Daily';
    
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('crs.labReportTatRange', $data);
    }

}
