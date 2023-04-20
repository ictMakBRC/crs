<?php

namespace App\Http\Controllers\CRS;

use App\Exports\PatientsExport;
use App\Helpers\ActivityTrail;
use App\Http\Controllers\Controller;
use App\Imports\resultsImport;
use App\Models\CRS\Facility;
use App\Models\CRS\Kit;
use App\Models\CRS\notification;
use App\Models\CRS\Platform;
use App\Models\CRS\Swabber;
use App\Models\CRS\wagonjwa;
use App\Models\Image;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WagonjwaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function referPatient($id)
     {
        $mugonjwa = wagonjwa::find($id);
        $data= [    
            'specimen_uuid' => $mugonjwa->sample_id,
            'eac_lab_id' => 'eyJpdiI6IklYR1Exb3M5UjRSYzN5SjlSa1ZjNWc9PSIsInZhbHVlIjoiV1pBSHNsdURyaGp4cEJYR0t3V0t3QT09IiwibWFjIjoiMWY3NDM1N2E4MmQxMTU2OTk4ZjIwMGQ2MDUxNzViMGRhZjY1ZDg4NjE3Y2IyZDYxMWQzMDdlMTU1NjE5Yzg2ZiJ9',   
            'status' => false,
            'referral_reason' => 'Out of reagents to test these samples',
            'destination_lab_id'=>'eyJpdiI6IklYR1Exb3M5UjRSYzN5SjlSa1ZjNWc9PSIsInZhbHVlIjoiV1pBSHNsdURyaGp4cEJYR0t3V0t3QT09IiwibWFjIjoiMWY3NDM1N2E4MmQxMTU2OTk4ZjIwMGQ2MDUxNzViMGRhZjY1ZDg4NjE3Y2IyZDYxMWQzMDdlMTU1NjE5Yzg2ZiJ9'
        ];

        // dd($patient);
        $client = new Client(['base_uri' => 'https://limsapi.cphluganda.org/receive/samples', 'verify' => false]);
        try {
            $res = $client->request('POST', 'https://limsapi.cphluganda.org/receive/samples', [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data),
            ]);       
          $mugonjwa->status = 'Referred';
          $mugonjwa-> update();          
          return redirect()->back()->with('success', $res->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\RequestException $e) {     
            return redirect()->back()->with('error', $e->getResponse()->getBody()->getContents());      
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => $e->getResponse()->getBody()->getContents()]);
        }
     }
    public function rdsComplete($id)
    {
        $mugonjwa = wagonjwa::find($id);
        $mugonjwa->rds_success = 202;
        $mugonjwa->rds_failure = null;
        $mugonjwa->update();

        $eventuser = auth()->user()->id;
        $patient = $id;
        $lab_no = 'N/A';
        $event = 'Completed RDS Results for Patient'.' '.$id;
        ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

        return redirect()->back()->with('success', 'Patient Record Successfully completed');
    }

    public function cancelSample($id)
    {
        $patient = Wagonjwa::findOrFail($id);
        if (Auth::user()->hasRole(['DataClerkSite']) && auth()->user()->facility_id == $patient->facility_id) {
            wagonjwa::where('id', $id)->where('status', 'collected')->update(['status' => 'Canceled']);
            $eventuser = auth()->user()->id;
            $patient = $id;
            $lab_no = 'N/A';
            $event = 'Canceled Patient'.' '.$id;
            ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

            return redirect()->back()->with('success', 'Patient Record Successfully canceled');
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function AdmincancelSample($id)
    {
        $patient = Wagonjwa::findOrFail($id);
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'ResultsApprover', 'ResultsQC'])) {
            wagonjwa::where('id', $id)->update(['status' => 'Canceled']);
            $eventuser = auth()->user()->id;
            $patient = $id;
            $lab_no = 'N/A';
            $event = 'Admin Canceled Patient'.' '.$id;
            ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

            return redirect()->back()->with('success', 'Patient Record Successfully canceled');
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function import()
    {
        $mybatch = request()->input('batch');
        try {
            DB::statement('SET foreign_key_checks=1');
            Excel::import(new resultsImport, request()->file('file')->store('files'));
            DB::statement('SET foreign_key_checks=1');
            // $mybatch = request()->input('batch');
            return redirect('patients/lab/result/pending/'.$mybatch)->with('success', 'The following Patients Records were Successfully imported !!');
        } catch (\Exception $error) {
            $value = new notification();
            $value->facility_id = auth()->user()->facility_id;
            $value->user_id = auth()->user()->id;
            $value->subject = 'Results Import Failure';
            $value->body = $error;
            $value->save();

            return redirect('patients/lab/result/pending/'.$mybatch)->with('error', 'An ERROR occured and some records where not imported');
        }
    }

    public function index()
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkSite', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('id', 'desc')
            ->select('*', 'wagonjwas.id as wid')
            ->where('facility_id', auth()->user()->facility_id)->get();
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        return view('crs.collectionPatientList', compact('patients'));
    }

    public function export()
    {
        return Excel::download(new PatientsExport(), 'patients.xlsx');
    }

    public function dashboard_show()
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $today = Carbon::now();
        $week = date('Y-M-W');

        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $totalTests = wagonjwa::count();
            $totalPostive = wagonjwa::where('result', 'Positive')->count();
            $totalPostive = wagonjwa::where('result', 'Positive')->count();
            $totalToday = wagonjwa::whereDay('created_at', '=', $today)->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count();
            $totalPending = wagonjwa::where('status', '!=', 'Completed')
            ->whereNull('result')
            ->where('status', '!=', 'Canceled')->count();
            $totalWithheld = wagonjwa::where('result', '!=', 'Positive')->where('result', '!=', 'Negative')->whereNotNull('result')->count();
            $totalEmergency = wagonjwa::where('priority', 'Emergency')->where('status', '!=', 'Canceled')->whereNull('result')->count();
            $totalWeek = wagonjwa::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select('created_at', DB::raw('count(id) as qty'))->get();

            $totalWeekPos = wagonjwa::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('result', 'Positive')->count();

            $totalMonth = wagonjwa::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))
            ->select('created_at', DB::raw('count(id) as qty'))->get();

            // $allMonthP = wagonjwa::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))
            // ->count();
            $totalMonthP = wagonjwa::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))
            ->where('result', 'Positive')->count();
            $totalYear = wagonjwa::select('created_at', DB::raw('count(id) as qty'))->whereYear('created_at', date('Y'))->get();
            $totalYearP = wagonjwa::whereYear('created_at', date('Y'))->where('result', 'Positive')->count();

            $facilitiesOn = Facility::where('is_active', 1)->count();
            $facilitiesOff = Facility::where('is_active', 0)->count();
            $users = User::count();

            $totalincoming = wagonjwa::where('status', '=', 'Collected')->count();

            $totalincomingfacility = wagonjwa::where('status', '=', 'Collected')
            ->distinct('facility_id')->count('facility_id');

            // B::table('tablename')->distinct('name')->count('name');
            //return $totalincomingfacility;
            $totalRecieved = wagonjwa::where('status', '=', 'Accessioned')->count();
            $totalValidated = wagonjwa::where('status', '=', 'Validated')->count();

            $totalTodayPositive = wagonjwa::whereDay('created_at', '=', $today)->whereDay('created_at', '=', $today)->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->where('result', 'Positive')->count();

            $countTat = wagonjwa::whereNotNull('result')->whereDay('wagonjwas.result_added_at', '=', $today)->count('id');
            $sumTat = wagonjwa::whereNotNull('result')->whereDay('wagonjwas.result_added_at', '=', $today)->sum('tat');

            try {
                $x = $sumTat + 0.1;
                $y = $countTat + 0.1;
                $avgTat = $x / $y;
            } catch (\Exception $error) {
                $avgTat = 0;
            }

            try {
                $x = $totalTodayPositive + 0.1;
                $y = $totalToday + 0.1;
                $avgpositives = $x / $y * 100;
                //$avgpositives = 0;
            } catch (\Exception $error) {
                $avgpositives = 0;
            }

            foreach ($totalMonth as $data) {
                $monthptv = $data->qty;
            }

            try {
                $x = $totalMonthP + 0.1;
                $y = $monthptv + 0.1;
                $avgMonthpositive = ($x / $y) * 100;
            } catch (\Exception $error) {
                $avgMonthpositive = 0;
            }
            try {
                $x = $totalPending + 0.1;
                $y = $totalToday + 0.1;
                $avgpending = ($x / $y) * 100;
            } catch (\Exception $error) {
                $avgpending = 0;
            }
            //====================getting last week %age=================================================
            $totalLastWeek = wagonjwa::whereBetween('created_at',
                [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
            )->count();
            $totalThisWeek = wagonjwa::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->count();
            try {
                $percentagelastWeek = ($totalLastWeek / $totalTests) * 100;
            } catch (\Exception $error) {
                $percentagelastWeek = 0;
            }
            try {
                $percentageThisWeek = ($totalThisWeek / $totalTests) * 100;
            } catch (\Exception $error) {
                $percentageThisWeek = 0;
            }

            $percentDiff = $percentageThisWeek - $percentagelastWeek;
            if ($percentDiff > 0) {
                $weekUp = '';
                $weekDown = 'd-none';
            } else {
                $weekUp = 'd-none';
                $weekDown = '';
            }
            //==================================================getting positivity difference==========================
            $yesterday = Carbon::yesterday();
            try {
                $percentTodaypositives = ($totalTodayPositive / $totalPostive) * 100;
            } catch (\Exception $error) {
                $percentTodaypositives = 0;
            }

            $totalYesterdayPositive = wagonjwa::whereDay('created_at', '=', $yesterday)->where('result', 'Positive')->count();
            try {
                $percentYestpositives = ($totalYesterdayPositive / $totalPostive) * 100;
            } catch (\Exception $error) {
                $percentYestpositives = 0;
            }

            $ntageTodayDiff = $percentTodaypositives - $percentYestpositives;
            if ($ntageTodayDiff > 0) {
                $TodayctiveUp = '';
                $TodayctiveDown = 'd-none';
            } else {
                $TodayctiveUp = 'd-none';
                $TodayctiveDown = '';
            }
            //========================================================tested today % difference==============================================

            $totalYesterday = wagonjwa::whereDay('created_at', '=', $yesterday)->count();
            try {
                $percentToday = ($totalToday / $totalTests) * 100;
            } catch (\Exception $error) {
                $percentToday = 0;
            }

            try {
                $percentYesterday = ($totalYesterday / $totalTests) * 100;
            } catch (\Exception $error) {
                $percentYesterday = 0;
            }

            $percentDiffToday = $percentToday - $percentYesterday;
            if ($percentDiffToday > 0) {
                $TodayUp = '';
                $TodayDown = 'd-none';
            } else {
                $TodayUp = 'd-none';
                $TodayDown = '';
            }

            $resultsgraph = wagonjwa::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%M-%Y') new_date"), DB::raw('YEAR(created_at) year'))
            ->groupBy(['new_date'])
            ->orderBy('year')
            ->limit(12)->get();

            if (count($resultsgraph) > 0) {
                foreach ($resultsgraph as $data) {
                    $month[] = $data->new_date;
                    $amount[] = $data->data;
                }
                $smonth = json_encode($month, JSON_NUMERIC_CHECK);
                $samount = json_encode($amount, JSON_NUMERIC_CHECK);
            } else {
                $smonth = '0';
                $samount = '0';
            }

            return view('crs.labdashboard', compact('avgpending', 'totalEmergency', 'totalWithheld', 'percentDiffToday', 'TodayDown', 'TodayUp', 'ntageTodayDiff', 'TodayctiveUp', 'TodayctiveDown', 'weekDown', 'weekUp', 'percentDiff', 'smonth', 'samount', 'avgTat', 'totalincomingfacility', 'avgMonthpositive', 'avgpositives', 'totalValidated', 'totalRecieved', 'totalincoming', 'users', 'totalTests', 'totalPending', 'totalToday', 'totalPostive', 'totalWeek', 'totalWeekPos', 'totalMonth', 'totalMonthP', 'totalYear', 'totalYearP', 'facilitiesOn', 'facilitiesOff'));
        } elseif (Auth::user()->hasRole(['DataClerkSite'])) {
            $totalTests = wagonjwa::where('facility_id', auth()->user()->facility_id)->count();
            $totalPostive = wagonjwa::where('result', 'Positive')->where('facility_id', auth()->user()->facility_id)->count();
            $totalPostive = wagonjwa::where('result', 'Positive')->where('facility_id', auth()->user()->facility_id)->count();
            $totalToday = wagonjwa::whereDay('created_at', '=', $today)->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->where('facility_id', auth()->user()->facility_id)->count();
            $totalPending = wagonjwa::where('status', '!=', 'Completed')->where('facility_id', auth()->user()->facility_id)->count();
            $totalWeek = wagonjwa::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select('created_at', DB::raw('count(id) as qty'))->where('facility_id', auth()->user()->facility_id)->get();
            $totalWeekPos = wagonjwa::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('result', 'Positive')->where('facility_id', auth()->user()->facility_id)->count();
            $totalMonth = wagonjwa::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))
            ->select('created_at', DB::raw('count(id) as qty'))->where('facility_id', auth()->user()->facility_id)->get();
            $totalMonthP = wagonjwa::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))
            ->where('result', 'Positive')->where('facility_id', auth()->user()->facility_id)->count();
            $totalYear = wagonjwa::select('created_at', DB::raw('count(id) as qty'))->whereYear('created_at', date('Y'))->where('facility_id', auth()->user()->facility_id)->get();
            $totalYearP = wagonjwa::whereYear('created_at', date('Y'))->where('result', 'Positive')->where('facility_id', auth()->user()->facility_id)->count();
            $users = User::where('facility_id', auth()->user()->facility_id)->count();
            $totalincoming = wagonjwa::where('status', '=', 'Collected')->where('facility_id', auth()->user()->facility_id)->count();
            $totalRecieved = wagonjwa::where('status', '=', 'Accessioned')->where('facility_id', auth()->user()->facility_id)->count();
            $totalValidated = wagonjwa::where('status', '=', 'Validated')->where('facility_id', auth()->user()->facility_id)->count();
            $totalTodayPositive = wagonjwa::whereDay('created_at', '=', $today)->where('result', 'Positive')->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->where('facility_id', auth()->user()->facility_id)->count();

            $totalLastMonth = wagonjwa::whereMonth('created_at', '=', $today->subMonth()->format('F'))->where('facility_id', auth()->user()->facility_id)->count();
            $totalWithheld = wagonjwa::where('result', '!=', 'Positive')->where('result', '!=', 'Negative')->whereNotNull('result')->where('facility_id', auth()->user()->facility_id)->count();
            try {
                $x = $totalTodayPositive + 0.1;
                $y = $totalToday + 0.1;
                $avgpositives = $x / $y * 100;
            } catch (\Exception $error) {
                $avgpositives = 0;
            }

            foreach ($totalMonth as $data) {
                $monthptv = $data->qty;
            }
            try {
                $x = $monthptv + 0.1;
                $y = $totalMonthP + 0.1;
                $avgMonthpositive = $x / $y * 100;
            } catch (\Exception $error) {
                $avgMonthpositive = 0;
            }
            try {
                $x = $totalPending + 0.1;
                $y = $totalToday + 0.1;
                $avgpending = ($x / $y) * 100;
            } catch (\Exception $error) {
                $avgpending = 0;
            }

            return view('crs.sitedashboard', compact('avgpending', 'totalWithheld', 'totalLastMonth', 'avgMonthpositive', 'avgpositives', 'totalValidated', 'totalRecieved', 'totalincoming', 'users', 'totalTests', 'totalPending', 'totalToday', 'totalPostive', 'totalWeek', 'totalWeekPos', 'totalMonth', 'totalMonthP', 'totalYear', 'totalYearP'));
        }
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
    }

    public function indexLab()
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('lab_no', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->paginate(99500);

            return view('crs.labPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function ManagePatients()
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
                ->select('*', 'wagonjwas.id as wid', 'wagonjwas.created_at as date')
                ->orderBy('wagonjwas.created_at', 'DESC')
               // ->orderBy('wagonjwas.lab_no', 'DESC')
                ->paginate(1500);

            //     $patients = wagonjwa::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%M-%Y') new_date"), DB::raw('YEAR(created_at) year'))
            // ->groupBy(['new_date'])
            // ->orderBy('year')
            // ->limit(12)->get();
            return view('admin.managePatients', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexEmergency()
    {
        $today = Carbon::now();
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('wagonjwas.id', 'desc')
                    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
                    ->select('*', 'wagonjwas.id as wid')
                    ->where('priority', 'Emergency')->whereNull('result')
                    ->paginate(99500);

            return view('crs.labPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexToday()
    {
        $today = Carbon::now();
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('lab_no', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->whereDay('wagonjwas.created_at', '=', $today)
            ->whereYear('wagonjwas.created_at', date('Y'))->whereMonth('wagonjwas.created_at', date('m'))
            ->paginate(10000);

            return view('crs.labPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexYesterday()
    {
        $today = Carbon::now();
        $yesterday = Carbon::yesterday();
        $yesterday = date('Y-m-d', strtotime('-1 days'));
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('lab_no', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
           ->whereDate('wagonjwas.created_at', '=', $yesterday)
            //->whereDate( 'wagonjwas.created_at', '>=', date('Y-m-d 17:00:00',strtotime("-1 days")))
            //->whereYear('wagonjwas.created_at', date('Y'))
            //->whereMonth('wagonjwas.created_at', date('m'))
            ->paginate(99500);

            return view('crs.labPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexMonths()
    {
        $today = Carbon::now();
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('lab_no', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->whereMonth('wagonjwas.created_at', '=', $today)
            ->whereYear('wagonjwas.created_at', date('Y'))
            ->paginate(1500);

            return view('crs.labPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexLastMonths()
    {
        $today = Carbon::now();
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('lab_no', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid', 'wagonjwas.created_at as created')
            // ->whereBetween('wagonjwas.created_at', ['2023-02-24 23:59:00', '2023-02-26 00:01:00'])
            ->whereMonth('wagonjwas.created_at', '=', Carbon::now()->subMonth()->month)
            //->whereYear('wagonjwas.created_at', date('Y'))
            ->paginate(1000);

            return view('crs.labPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexWeek()
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('lab_no', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->whereBetween('wagonjwas.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->paginate(1500);

            return view('crs.labPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexFilter(Request $request)
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('facilities.id', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->whereBetween('wagonjwas.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->paginate(99500);

            return view('crs.labPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexTodayC()
    {
        $today = Carbon::now();
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkSite', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('facilities.id', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->whereDay('wagonjwas.created_at', '=', $today)
            ->whereYear('wagonjwas.created_at', date('Y'))->whereMonth('wagonjwas.created_at', date('m'))
            ->where('facility_id', auth()->user()->facility_id)->get();

            return view('crs.collectionPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexMonthsC()
    {
        $today = Carbon::now();
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkSite', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('facilities.id', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->whereMonth('wagonjwas.created_at', '=', $today)
            ->whereYear('wagonjwas.created_at', date('Y'))
            ->where('facility_id', auth()->user()->facility_id)->get();

            return view('crs.collectionPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexWeekC()
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkSite', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('facilities.id', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->whereBetween('wagonjwas.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('facility_id', auth()->user()->facility_id)->get();

            return view('crs.collectionPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function indexFilterC(Request $request)
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkSite', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $patients = wagonjwa::orderBy('facilities.id', 'desc')
            ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->whereBetween('wagonjwas.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('facility_id', auth()->user()->facility_id)->get();

            return view('crs.collectionPatientList', compact('patients'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkSite', 'DataClerkLab', 'ResultsApprover', 'ResultsQC'])) {
            $swabber = Swabber::where('status', 'Active')->where('facility_id', auth()->user()->facility_id)
            ->orderBy('full_name', 'asc')->get();
            $facility = Facility::with('parent')->where('id', auth()->user()->facility_id)->first();
            //return $facility;
            return view('crs.newPatient', compact('swabber', 'facility'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    //creating a lab patient
    public function createLab()
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $swabber = Swabber::where('status', 'Active')
            ->orderBy('full_name', 'asc')->get();
            $facilities = Facility::orderBy('facility_name', 'asc')->get();
        // $client = new Client(['base_uri' => 'https://apitest.cphluganda.org/covid_suspects', 'verify' => false]);
        // try {
        //     $res = $client->request('GET', 'https://apitest.cphluganda.org/covid_suspects',[
        //         'auth' => [
        //             'uvri_lims', '4B>{jaE54^_azqR['
        //         ]
        //     ]);

        //     $data = collect(json_decode($res->getBody(), true));
        //     $external_patients=$data;
        // } catch (\GuzzleHttp\Exception\RequestException $e) {

        //     $external_patients = collect([]);
        // }
            return view('crs.LabNewPatient', compact('facilities', 'swabber'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                //'patient_id'=>'required|unique:wagonjwas',
                'surname' => 'required',
                'given_name' => 'required',
                'other_name',
                'priority',
                // 'dob'=>'required',
                // 'nok_name'=>'required',
                'who_tested' => 'required',
                'test_reason' => 'required',
                'gender' => 'required',
                //'age'=>'required',
                'phone_number',
                'nationality' => 'required',
                'patient_district' => 'required',
                'swab_district' => 'required',
                'collection_date' => 'required',
                'collected_by' => 'required',
                'sample_type' => 'required',
                'ever_been_positive' => 'required',
                'ever_been_vaccinated' => 'required',
                'entry_type' => 'required',
                //'doc_type'=>'required',
                //'doc_no'=>'required',
            ]);
            $photoPath = '';
            $tubePath = '';
            $status = '';
            $pat_no = '';
            $today = Carbon::now();
            $sevenDayTest = Wagonjwa::where(['doc_no' => $request->doc_no, 'result' => 'Positive'])->where('result_added_at', '>', $today->subDays(7))->latest()->first();
            $latestPatNo = Wagonjwa::select('pat_no')->whereNotNull('pat_no')->orderBy('id', 'desc')->first();
            //$count=Wagonjwa::count();
            if ($latestPatNo) {
                $pat_no = 'BRC-'.(substr(explode('-', $latestPatNo->pat_no)[1], 0, -1) + 1).'P';
            } else {
                $pat_no = 'BRC-10000P';
            }
            //return $pat_no;
            if ($sevenDayTest) {
                $status = 'Withheld';
            } else {
                $status = 'No';
            }
            // try{

            //     if ($request->hasFile('patient_photo') && $request->hasFile('tube_photo'))
            //     {
            //         $request->validate(['patient_photo'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048']);
            //         $photoPath = $request->file('patient_photo')->storeAs('patient_photos',$request->file('patient_photo')->getClientOriginalName(),'public');
            //         $tubePath = $request->file('tube_photo')->storeAs('tube_photos',$request->file('tube_photo')->getClientOriginalName(),'public');
            //     }

            //     }
            // catch(\Exception $error)
            // {

            //     return redirect()->back()->with('error', 'Something occured '.$error);
            // }
            if ($request->input('entry_type') == 'Internal') {
                $facility = $request->input('facility_id');
            } else {
                $facility = auth()->user()->facility_id;
            }
            $value = new wagonjwa();
            $value->patient_id = $request->input('patient_id');
            $value->pat_no = $pat_no;
            $value->surname = $request->input('surname');
            $value->given_name = $request->input('given_name');
            $value->other_name = $request->input('other_name');
            $value->priority = $request->input('priority');
            // $value->tube_photo= $tubePath;
            // $value-> patient_photo= $photoPath;
            $value->dob = $request->input('dob') ? Carbon::parse($request->input('dob'))->format('Y-m-d') : null;
            $value->nok_name = $request->input('nok_name');
            $value->patient_email = $request->input('patient_email');
            $value->who_tested = $request->input('who_tested');
            $value->test_reason = $request->input('test_reason');
            $value->gender = $request->input('gender');
            $value->age = $request->input('age');
            $value->phone_number = $request->input('phone_number');
            $value->nationality = $request->input('nationality');
            $value->patient_district = $request->input('patient_district');
            $value->swab_district = $request->input('swab_district');
            $value->collection_date = $request->input('collection_date');
            $value->collected_by = $request->input('collected_by');
            $value->sample_type = $request->input('sample_type');
            $value->ever_been_positive = $request->input('ever_been_positive');
            $value->ever_been_vaccinated = $request->input('ever_been_vaccinated');
            $value->vaccine_dose1 = $request->input('vaccine_dose1');
            $value->vaccine_dose2 = $request->input('vaccine_dose2');
            $value->vaccine_dose3 = $request->input('vaccine_dose3');
            $value->doc_type = $request->input('doc_type');
            $value->doc_no = $request->input('doc_no');
            $value->created_by = auth()->user()->id;
            $value->facility_type_id = $facility;
            $value->facility_id = $facility;
            $value->duplicate = $status;
            $value->entry_type = $request->input('entry_type');
            $value->save();

            $eventuser = auth()->user()->id;
            $patient = $value->id;
            $lab_no = 'N/A';
            $event = 'Added Patient'.' '.$request->input('patient_id').' '.'Sample collected/Swabbed by'.' '.$request->input('collected_by');
            ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

            return redirect()->back()->with('success', 'Patient Record Successfully added !!');
        } catch (\Exception $error) {
            $value = new notification();
            $value->facility_id = $facility;
            $value->user_id = auth()->user()->id;
            $value->subject = 'Patient insert Failure';
            $value->body = $error;
            $value->save();

            return redirect()->back()->with('error', 'Error!! Something occured, Patient record could not be created. Please try again or contact the System Administrator for help');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showpatient($id)
    {
        if (Auth::user()->hasRole(['DataAdmin', 'DataClerkLab', 'LabTech', 'ResultsApprover', 'ResultsQC'])) {
            $results = wagonjwa::addSelect(
                [
                    'facility' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                    'createdby' => User::select('surname')->whereColumn('wagonjwas.created_by', 'users.id'),
                    'createdbyfn' => User::select('first_name')->whereColumn('wagonjwas.created_by', 'users.id'),
                    'accessionedby' => User::select('surname')->whereColumn('wagonjwas.accessioned_by', 'users.id'),
                    'accessionedbyfn' => User::select('first_name')->whereColumn('wagonjwas.accessioned_by', 'users.id'),
                    'enteredby' => User::select('surname')->whereColumn('wagonjwas.entered_by', 'users.id'),
                    'enteredbyfn' => User::select('first_name')->whereColumn('wagonjwas.entered_by', 'users.id'),
                    'result_addedby' => User::select('surname')->whereColumn('wagonjwas.result_added_by', 'users.id'),
                    'result_addedbyfn' => User::select('first_name')->whereColumn('wagonjwas.result_added_by', 'users.id'),
                    'swabber' => Swabber::select('full_name')->whereColumn('wagonjwas.collected_by', 'swabbers.id'),
                ]
            )->where('id', $id)->get();

            $trails = wagonjwa::leftJoin('activity_trails', 'wagonjwas.id', '=', 'activity_trails.wagonjwa_id')
    ->leftJoin('users', 'activity_trails.user_id', '=', 'users.id')->where('wagonjwas.id', $id)
    ->select('*', 'wagonjwas.surname as sname', 'wagonjwas.given_name as gname', 'wagonjwas.other_name as oname', 'activity_trails.created_at as date')->get();

            return view('crs.ViewPatient', compact('results', 'trails'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function show($id)
    {
        $patient = Wagonjwa::findOrFail($id);
        if (Auth::user()->hasRole(['DataClerkSite']) && auth()->user()->facility_id == $patient->facility_id) {
            $results = wagonjwa::addSelect(
                [
                    'facility' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                    'createdby' => User::select('surname')->whereColumn('wagonjwas.created_by', 'users.id'),
                    'createdbyfn' => User::select('first_name')->whereColumn('wagonjwas.created_by', 'users.id'),
                    'accessionedby' => User::select('surname')->whereColumn('wagonjwas.accessioned_by', 'users.id'),
                    'accessionedbyfn' => User::select('first_name')->whereColumn('wagonjwas.accessioned_by', 'users.id'),
                    'enteredby' => User::select('surname')->whereColumn('wagonjwas.entered_by', 'users.id'),
                    'enteredbyfn' => User::select('first_name')->whereColumn('wagonjwas.entered_by', 'users.id'),
                    'result_addedby' => User::select('surname')->whereColumn('wagonjwas.result_added_by', 'users.id'),
                    'result_addedbyfn' => User::select('first_name')->whereColumn('wagonjwas.result_added_by', 'users.id'),
                    'swabber' => Swabber::select('full_name')->whereColumn('wagonjwas.collected_by', 'swabbers.id'),
                ]
            )->where('id', $id)->get();

            $trails = wagonjwa::leftJoin('activity_trails', 'wagonjwas.id', '=', 'activity_trails.wagonjwa_id')
    ->leftJoin('users', 'activity_trails.user_id', '=', 'users.id')
    ->select('*', 'wagonjwas.surname as sname', 'wagonjwas.given_name as gname', 'wagonjwas.other_name as oname', 'activity_trails.created_at as date')
    ->where('wagonjwas.id', $id)->get();

            return view('crs.ViewPatient', compact('results', 'trails'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    
    public function showLab($id)
    {
        $swabber = Swabber::where('status', 'Active')
        ->orderBy('full_name', 'asc')->get();
        $values = wagonjwa::where('id', $id)->get();

        return view('crs.editPatient', compact('values'));
    }

    

    public function getPatient(Request $request)
    {
        $pat_no = $request->pat_no;
        $token = $request->token;
        if($token == 'ASHS773HD8883HDXHDHY'){
          $results = wagonjwa::addSelect(
                [
                    'facility' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                    'createdby' => User::select('surname')->whereColumn('wagonjwas.created_by', 'users.id'),
                    'createdbyfn' => User::select('first_name')->whereColumn('wagonjwas.created_by', 'users.id'),
                    'accessionedby' => User::select('surname')->whereColumn('wagonjwas.accessioned_by', 'users.id'),
                    'accessionedbyfn' => User::select('first_name')->whereColumn('wagonjwas.accessioned_by', 'users.id'),
                    'enteredby' => User::select('surname')->whereColumn('wagonjwas.entered_by', 'users.id'),
                    'enteredbyfn' => User::select('first_name')->whereColumn('wagonjwas.entered_by', 'users.id'),
                    'result_addedby' => User::select('surname')->whereColumn('wagonjwas.result_added_by', 'users.id'),
                    'result_addedbyfn' => User::select('first_name')->whereColumn('wagonjwas.result_added_by', 'users.id'),
                    'swabber' => Swabber::select('full_name')->whereColumn('wagonjwas.collected_by', 'swabbers.id'),
                ]
            )->where('pat_no', $pat_no)->get();


            return response()->json($results, 200);
            
        }else{
         
                 return response()->json(4001);
      
        }
       
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = Wagonjwa::findOrFail($id);
        if (Auth::user()->hasRole(['DataClerkSite', 'DataClerkLab', 'DataAdmin']) && auth()->user()->facility_id == $patient->facility_id) {
            $swabber = Swabber::where('status', 'Active')->where('facility_id', auth()->user()->facility_id)
            ->orderBy('full_name', 'asc')->get();
            $values = wagonjwa::where('wagonjwas.id', $id)
            ->leftJoin('swabbers', 'wagonjwas.collected_by', '=', 'swabbers.id')
            ->select('*', 'wagonjwas.id as wid')->get();

            return view('crs.editPatient', compact('values', 'swabber'));
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function editLab($id)
    {
        $swabber = Swabber::where('status', 'Active')
        ->orderBy('full_name', 'asc')->get();
        $facilities = Facility::orderBy('facility_name', 'asc')->get();
        $kits = Kit::orderBy('kit_name', 'asc')->get();
        $platforms = Platform::orderBy('platform_name', 'asc')->get();
        $values = wagonjwa::orderBy('facilities.id', 'desc')
        ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
        ->select('*', 'wagonjwas.id as wid')
        ->leftJoin('swabbers', 'wagonjwas.collected_by', '=', 'swabbers.id')
        ->leftJoin('kits', 'wagonjwas.test_kit', '=', 'kits.id')
        ->where('wagonjwas.id', $id)->get();

        return view('crs.LabAddResults', compact('values', 'facilities', 'kits', 'platforms', 'swabber'));
    }

    public function AdminEditResults($id)
    {
        $swabber = Swabber::where('status', 'Active')
        ->orderBy('full_name', 'asc')->get();
        $facilities = Facility::orderBy('facility_name', 'asc')->get();
        $kits = Kit::orderBy('kit_name', 'asc')->get();
        $platforms = Platform::orderBy('platform_name', 'asc')->get();
        $values = wagonjwa::orderBy('facilities.id', 'desc')
        ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
        ->select('*', 'wagonjwas.id as wid')
        ->leftJoin('swabbers', 'wagonjwas.collected_by', '=', 'swabbers.id')
        ->leftJoin('kits', 'wagonjwas.test_kit', '=', 'kits.id')
        ->leftJoin('platforms', 'wagonjwas.platform', '=', 'platforms.id')
        ->where('wagonjwas.id', $id)->get();

        return view('admin.managePatientResult', compact('values', 'facilities', 'kits', 'platforms', 'swabber'));
    }

    public function validateLab($id)
    {
        $swabber = Swabber::where('status', 'Active')
        ->orderBy('full_name', 'asc')->get();
        $facilities = Facility::with('parent')->orderBy('facility_name', 'asc')->get();
        $kits = Kit::orderBy('kit_name', 'asc')->get();
        $platforms = Platform::orderBy('platform_name', 'asc')->get();
        $values = wagonjwa::with('facility', 'facility.parent')
        // ->leftJoin('facilities','wagonjwas.facility_id','=','facilities.id')
        ->select('*', 'wagonjwas.id as wid')
        ->leftJoin('swabbers', 'wagonjwas.collected_by', '=', 'swabbers.id')
        ->leftJoin('kits', 'wagonjwas.test_kit', '=', 'kits.id')
        ->where('wagonjwas.id', $id)->get();

        return view('crs.LabValidatePatient', compact('values', 'facilities', 'kits', 'platforms', 'swabber'));
    }

    public function AdminvalidateLab($id)
    {
        $swabber = Swabber::where('status', 'Active')
            ->orderBy('full_name', 'asc')->get();
        $facilities = Facility::with('parent')->orderBy('facility_name', 'asc')->get();
        $kits = Kit::orderBy('kit_name', 'asc')->get();
        $platforms = Platform::orderBy('platform_name', 'asc')->get();
        $values = wagonjwa::with('facility', 'facility.parent')
            // ->leftJoin('facilities','wagonjwas.facility_id','=','facilities.id')
            ->select('*', 'wagonjwas.id as wid')
            ->leftJoin('swabbers', 'wagonjwas.collected_by', '=', 'swabbers.id')
            ->leftJoin('kits', 'wagonjwas.test_kit', '=', 'kits.id')
            ->where('wagonjwas.id', $id)->get();

        return view('admin.updatePatient', compact('values', 'facilities', 'kits', 'platforms', 'swabber'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateLab(Request $request, $id)
    {
        $this->validate($request, [
            'lab_no' => 'required',
        ]);
        try {
            $value = wagonjwa::find($id);
            $value->lab_no = str_replace(' ', '', $request->input('lab_no'));
            $value->date_recieved = date('Y-m-d H:i:s');
            $value->accessioned_by = auth()->user()->id;
            $value->accessioned_at = date('Y-m-d H:i:s');
            $value->status = 'Accessioned';
            $value->update();

            $eventuser = auth()->user()->id;
            $patient = $value->id;
            $lab_no = $request->input('lab_no');
            $event = 'Updated/Accessioned Patient'.' '.$value->patient_id.' '.'with Lab Number'.$request->input('lab_no');
            ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

            return redirect()->back()->with('success', 'Lab No Record Successfully updated !!');
        } catch (\Exception $error) {
            return redirect()->back()->with('error', 'Something Went Wrong or Lab No. already assigned to someone else ! ');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'surname' => 'required',
            'given_name' => 'required',
            'other_name',
            'patient_email',
            'test_reason' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'patient_district' => 'required',
            'swab_district' => 'required',
            'collection_date' => 'required',
            'collected_by' => 'required',
            'sample_type' => 'required',
            'ever_been_positive' => 'required',
            'ever_been_vaccinated' => 'required',

        ]);
        //
        $value = wagonjwa::find($id);

        $value->patient_id = $request->input('patient_id');
        $value->surname = $request->input('surname');
        $value->given_name = $request->input('given_name');
        $value->other_name = $request->input('other_name');
        $value->dob = $request->input('dob') ? Carbon::parse($request->input('dob'))->format('Y-m-d') : null;
        $value->nok_name = $request->input('nok_name');
        $value->patient_email = $request->input('patient_email');
        $value->test_reason = $request->input('test_reason');
        $value->gender = $request->input('gender');
        $value->age = $request->input('age');
        $value->phone_number = $request->input('phone_number');
        $value->nationality = $request->input('nationality');
        $value->patient_district = $request->input('patient_district');
        $value->swab_district = $request->input('swab_district');
        $value->collection_date = $request->input('collection_date');
        $value->collected_by = $request->input('collected_by');
        $value->sample_type = $request->input('sample_type');
        $value->ever_been_positive = $request->input('ever_been_positive');
        $value->ever_been_vaccinated = $request->input('ever_been_vaccinated');
        $value->vaccine_dose1 = $request->input('vaccine_dose1');
        $value->vaccine_dose2 = $request->input('vaccine_dose2');
        $value->vaccine_dose3 = $request->input('vaccine_dose3');
        $value->doc_type = $request->input('doc_type');
        $value->doc_no = $request->input('doc_no');
        $value->update();

        $eventuser = auth()->user()->id;
        $patient = $value->id;
        $lab_no = $value->lab_no;
        $event = 'Updated Patient'.' '.$request->input('patient_id').json_encode($value->getChanges());
        ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

        return redirect()->back()->with('success', 'Patient Record Successfully updated !!');
    }

    public function updatePatientLab(Request $request, $id)
    {
        $this->validate($request, [
            'surname' => 'required',
            'given_name' => 'required',
            'other_name',
            'test_reason' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'patient_district' => 'required',
            'swab_district' => 'required',
            'collection_date' => 'required',
            'collected_by' => 'required',
            'sample_type' => 'required',
            'who_tested' => 'required',
            'ever_been_positive' => 'required',
            'ever_been_vaccinated' => 'required',
            'receipt_no',
            'test_arm',
            'facility_id' => 'required',
        ]);

        $value = wagonjwa::find($id);
        $value->lab_no = $request->input('lab_no');
        $value->patient_id = $request->input('patient_id');
        $value->surname = $request->input('surname');
        $value->given_name = $request->input('given_name');
        $value->other_name = $request->input('other_name');
        $value->dob = $request->input('dob') ? Carbon::parse($request->input('dob'))->format('Y-m-d') : null;
        $value->nok_name = $request->input('nok_name');
        $value->patient_email = $request->input('patient_email');
        $value->who_tested = $request->input('who_tested');
        $value->test_reason = $request->input('test_reason');
        $value->gender = $request->input('gender');
        $value->age = $request->input('age');
        $value->phone_number = $request->input('phone_number');
        $value->nationality = $request->input('nationality');
        $value->patient_district = $request->input('patient_district');
        $value->swab_district = $request->input('swab_district');
        $value->collection_date = $request->input('collection_date');
        $value->collected_by = $request->input('collected_by');
        $value->sample_type = $request->input('sample_type');
        $value->ever_been_positive = $request->input('ever_been_positive');
        $value->ever_been_vaccinated = $request->input('ever_been_vaccinated');
        $value->vaccine_dose1 = $request->input('vaccine_dose1');
        $value->vaccine_dose2 = $request->input('vaccine_dose2');
        $value->vaccine_dose3 = $request->input('vaccine_dose3');
        $value->receipt_no = $request->input('receipt_no');
        $value->test_arm = $request->input('test_arm');
        $value->doc_type = $request->input('doc_type');
        $value->doc_no = $request->input('doc_no');
        $value->facility_id = $request->input('facility_id');
        $value->entered_by = auth()->user()->id;
        $value->entered_at = date('Y-m-d H:i:s');
        $value->status = 'Validated';

        $value->update();

        $eventuser = auth()->user()->id;
        $patient = $value->id;
        $lab_no = $value->lab_no;
        $event = 'Updated Patient'.' '.$request->input('patient_id').json_encode($value->getChanges());
        ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

        return redirect('patients/lab/accessioned/week')->with('success', 'Patient Record Successfully updated !!');
    }

    public function AdminUpdatePatient(Request $request, $id)
    {
        $this->validate($request, [
            'surname' => 'required',
            'given_name' => 'required',
            'other_name',
            'test_reason' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'patient_district' => 'required',
            'swab_district' => 'required',
            'collection_date' => 'required',
            'collected_by' => 'required',
            'sample_type' => 'required',
            'who_tested' => 'required',
            'ever_been_positive' => 'required',
            'ever_been_vaccinated' => 'required',
            'receipt_no',
            'test_arm',
            'facility_id' => 'required',
        ]);

        $value = wagonjwa::find($id);
        $value->lab_no = $request->input('lab_no');
        $value->patient_id = $request->input('patient_id');
        $value->surname = $request->input('surname');
        $value->given_name = $request->input('given_name');
        $value->other_name = $request->input('other_name');
        $value->dob = $request->input('dob');
        $value->nok_name = $request->input('nok_name');
        $value->patient_email = $request->input('patient_email');
        $value->who_tested = $request->input('who_tested');
        $value->test_reason = $request->input('test_reason');
        $value->gender = $request->input('gender');
        $value->age = $request->input('age');
        $value->phone_number = $request->input('phone_number');
        $value->nationality = $request->input('nationality');
        $value->patient_district = $request->input('patient_district');
        $value->swab_district = $request->input('swab_district');
        $value->collection_date = $request->input('collection_date');
        $value->collected_by = $request->input('collected_by');
        $value->sample_type = $request->input('sample_type');
        $value->ever_been_positive = $request->input('ever_been_positive');
        $value->ever_been_vaccinated = $request->input('ever_been_vaccinated');
        $value->vaccine_dose1 = $request->input('vaccine_dose1');
        $value->vaccine_dose2 = $request->input('vaccine_dose2');
        $value->vaccine_dose3 = $request->input('vaccine_dose3');
        $value->receipt_no = $request->input('receipt_no');
        $value->test_arm = $request->input('test_arm');
        $value->doc_type = $request->input('doc_type');
        $value->doc_no = $request->input('doc_no');
        $value->facility_id = $request->input('facility_id');
        // return redirect()->back()->with('success', 'Patient Record Successfully updated !!');
        $value->update();

        $eventuser = auth()->user()->id;
        $patient = $value->id;
        $lab_no = $value->lab_no;
        $event = 'Admin Updated Patient'.' '.$request->input('patient_id').json_encode($value->getChanges());
        ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

        return redirect()->back()->with('success', 'Patient Record Successfully updated !!');
    }

    public function updateLabResults(Request $request, $id)
    {
        $this->validate($request, [
            'result' => 'required',
            'worksheet_no' => 'required',
            'test_type' => 'required',
            'test_kit' => 'required',
            'ct_value' => 'required',
            'ct_value2',
            'ct_value3',
            'ct_value4',
            'target1' => 'required',
            'target2',
            'target3',
            'target4',
            'platform' => 'required',
            'igg_result',
            'igm_result',
            'collection_date' => 'required',
            //'tat'=>'required',
            'comment',
        ]);

        $today = Carbon::now();
        $to = Carbon::createFromFormat('Y-m-d H:s:i', $today);
        $from = Carbon::createFromFormat('Y-m-d H:s:i', $request->input('collection_date'));
        $tat = $to->diffInHours($from);

        $value = wagonjwa::find($id);
        $value->result = $request->input('result');
        $value->worksheet_no = $request->input('worksheet_no');
        $value->rds_test_type = 'SARS-CoV2';
        $value->test_type = $request->input('test_type');
        $value->test_kit = $request->input('test_kit');
        $value->ct_value = $request->input('ct_value');
        $value->ct_value2 = $request->input('ct_value2');
        $value->ct_value3 = $request->input('ct_value3');
        $value->ct_value4 = $request->input('ct_value4');
        $value->target1 = $request->input('target1');
        $value->target2 = $request->input('target2');
        $value->target3 = $request->input('target3');
        $value->target4 = $request->input('target4');
        $value->platform = $request->input('platform');
        $value->tat = $tat;
        $value->results_approver_name = 'Edgar Kigozi';
        $value->approver_signature = 'Edgar Kigozi';
        $value->igg_result = $request->input('igg_result');
        $value->igm_result = $request->input('igm_result');
        $value->comment = $request->input('comment');
        $value->result_added_by = auth()->user()->id;
        $value->result_updated_at = date('Y-m-d H:i:s');
        $value->result_added_at = date('Y-m-d H:i:s');
        $value->status = 'Completed';

        $value->update();
        $eventuser = auth()->user()->id;
        $patient = $value->id;
        $lab_no = $value->lab_no;
        $event = 'Produced Results for Patient'.' '.$request->input('patient_id');

        ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

        return redirect('patients/lab/validated/week')->with('success', 'Patient Results Successfully updated !!');
    }

    public function AdimUpdateResults(Request $request, $id)
    {
        $this->validate($request, [
            'result' => 'required',
            'worksheet_no' => 'required',
            'test_type' => 'required',
            'test_kit' => 'required',
            'ct_value' => 'required',
            'ct_value2',
            'ct_value3',
            'ct_value4',
            'target1' => 'required',
            'target2',
            'target3',
            'target4',
            'platform' => 'required',
            'igg_result',
            'igm_result',
            'collection_date' => 'required',
            //'tat'=>'required',
            'comment',
        ]);

        $today = Carbon::now();
        $to = Carbon::createFromFormat('Y-m-d H:s:i', $today);
        $from = Carbon::createFromFormat('Y-m-d H:s:i', $request->input('collection_date'));
        $tat = $to->diffInHours($from);

        $value = wagonjwa::find($id);
        $value->result = $request->input('result');
        $value->worksheet_no = $request->input('worksheet_no');
        $value->rds_test_type = 'SARS-CoV2';
        $value->test_type = $request->input('test_type');
        $value->test_kit = $request->input('test_kit');
        $value->ct_value = $request->input('ct_value');
        $value->ct_value2 = $request->input('ct_value2');
        $value->ct_value3 = $request->input('ct_value3');
        $value->ct_value4 = $request->input('ct_value4');
        $value->target1 = $request->input('target1');
        $value->target2 = $request->input('target2');
        $value->target3 = $request->input('target3');
        $value->target4 = $request->input('target4');
        $value->platform = $request->input('platform');
        $value->tat = $tat;
        $value->results_approver_name = 'Edgar Kigozi';
        $value->approver_signature = 'Edgar Kigozi';
        $value->igg_result = $request->input('igg_result');
        $value->igm_result = $request->input('igm_result');
        $value->comment = $request->input('comment');
        $value->result_added_by = auth()->user()->id;
        $value->result_updated_at = date('Y-m-d H:i:s');
        // $value->result_added_at= date('Y-m-d H:i:s');
        $value->status = 'Completed';

        $value->update();
        $eventuser = auth()->user()->id;
        $patient = $value->id;
        $lab_no = $value->lab_no;
        $event = 'Updated Results for Patient'.' '.$request->input('patient_id');

        ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

        return redirect()->back()->with('success', 'Patient Results Successfully updated !!');
    }

    public function result()
    {
        return view('crs.patientResult');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPatientLab($id)
    {
        $mugonjwa = Wagonjwa::findOrFail($id);
        $eventuser = auth()->user()->id;
        $patient = $mugonjwa->id;
        $lab_no = $mugonjwa->lab_no ? $mugonjwa->lab_no : 'N/A';
        $event = 'Deleted Patient '.$mugonjwa->surname.' '.$mugonjwa->given_name;
        $mugonjwa->delete();
        ActivityTrail::addToTrail($eventuser, $patient, $lab_no, $event);

        return redirect()->back()->with('success', 'Patient record was deleted successfully');
    }

    public function destroy($id)
    {
        //
    }

    public function send_to_rds($id)
    {
        $data = wagonjwa::addSelect(
            [
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'requester_name' => Facility::select('requester_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'requester_contact' => Facility::select('requester_contact')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'collectedby' => Swabber::select('full_name')->whereColumn('wagonjwas.collected_by', 'swabbers.id'),
                'platform' => Platform::select('platform_name')->whereColumn('wagonjwas.platform', 'platforms.id'),
                'platform_range' => Platform::select('platform_range')->whereColumn('wagonjwas.platform', 'platforms.id'),
                'kit' => Kit::select('kit_name')->whereColumn('wagonjwas.test_kit', 'kits.id'),

            ]
        )->where(['id' => $id, 'status' => 'Completed'])
        //->whereNull('rds_success')
        ->get();

        $mugonjwa = wagonjwa::findOrFail($id);
        $doseCount = '';
        $ct_value = '';
        //return $mugonjwa;

        $patient = $data->map(function ($result) {
            if ($result->vaccine_dose1 == null && $result->vaccine_dose2 == null && $result->vaccine_dose3 == null) {
                $doseCount = 0;
            } elseif ($result->vaccine_dose1 && $result->vaccine_dose2 == null && $result->vaccine_dose3 == null) {
                $doseCount = 1;
            } elseif ($result->vaccine_dose1 && $result->vaccine_dose2 && $result->vaccine_dose3 == null) {
                $doseCount = 2;
            } elseif ($result->vaccine_dose1 && $result->vaccine_dose3 && $result->vaccine_dose2 == null) {
                $doseCount = 2;
            } elseif ($result->vaccine_dose1 && $result->vaccine_dose2 && $result->vaccine_dose3) {
                $doseCount = 3;
            } else {
                $doseCount = 0;
            }

            $confirmatory_value = $result->ct_value > 0 && $result->ct_value < 38 ? '='.$result->ct_value : '=0.000';

            if ($result->target1 != null && $result->target2 != null && $result->target3 != null && $result->target4 != null &&
            $result->ct_value != null && $result->ct_value2 != null && $result->ct_value3 != null && $result->ct_value4 != null) {
                $ct_value = $result->target1.$confirmatory_value.' '.$result->target2.'='.$result->ct_value2.' '.$result->target3.'='.$result->ct_value3.' '.$result->target4.'='.$result->ct_value4;
            } elseif ($result->target1 != null && $result->target2 != null && $result->target3 != null && $result->target4 == null &&
            $result->ct_value != null && $result->ct_value2 != null && $result->ct_value3 != null && $result->ct_value4 == null) {
                $ct_value = $result->target1.$confirmatory_value.' '.$result->target2.'='.$result->ct_value2.' '.$result->target3.'='.$result->ct_value3;
            } elseif ($result->target1 != null && $result->target2 != null && $result->target3 == null && $result->target4 == null && $result->ct_value != null && $result->ct_value2 != null && $result->ct_value3 == null && $result->ct_value4 == null) {
                $ct_value = $result->target1.$confirmatory_value.' '.$result->target2.'='.$result->ct_value2;
            } elseif (
                $result->target1 != null && $result->target2 == null && $result->target3 == null && $result->target4 == null &&
                $result->ct_value != null && $result->ct_value2 == null && $result->ct_value3 == null && $result->ct_value4 == null) {
                $ct_value = $result->target1.$confirmatory_value;
            } else {
                if ($result->result == 'Negative') {
                    $ct_value = $result->target1.'=0.000';
                }
            }
            // if($result->result=='Negative'){
            //     $ct_value="0.000";
            // }

            return [
                'token' => 'JtVN36GVZmTz3AO1nVMZrNAJIkip5bvIatim20190321',
                'result' => [
                    [
                        'patient_identifier' => $result->pat_no != '' ? $result->pat_no : null,
                        'ever_tested_positive' => $result->ever_been_positive != '' ? $result->ever_been_positive : null,
                        'is_vaccinated' => $result->ever_been_vaccinated != '' ? $result->ever_been_vaccinated : null,
                        'vaccine_type' => $result->vaccine_dose1 != '' ? $result->vaccine_dose1 : 'NA',
                        'doses_received' => $doseCount != '' ? $doseCount : 0,
                        'last_vaccination_date' => null,
                        'requester_name' => $result->requester_name != '' ? $result->requester_name : null,
                        'requester_facility' => $result->collection_site != '' ? $result->collection_site : null,
                        'requester_contact' => $result->requester_contact != '' ? $result->requester_contact : null,
                        'type_of_site' => $result->facility_type != '' ? $result->facility_type : null,
                        'sample_collection_site' => $result->collection_site != '' ? $result->collection_site : null,
                        'sample_collection_district' => $result->swab_district != '' ? $result->swab_district : null,
                        'who_tested' => $result->who_tested != '' ? $result->who_tested : null,
                        'reason_for_hw_testing' => $result->test_reason != '' ? $result->test_reason : null,
                        'client_isolated' => null,
                        'day_of_testing' => null,
                        'traveled_out' => null,
                        'country_visited' => null,
                        'additional_travel_comments' => null,
                        'return_date' => null,
                        'client_name' => $result->surname.' '.$result->given_name.' '.$result->other_name,
                        'passport_number' => $result->doc_no != '' ? $result->doc_no : null,
                        'email_address' => $result->patient_email != '' ? $result->patient_email : null,
                        'receipt_number' => $result->receipt_no != '' ? $result->receipt_no : null,
                        'eacpass_id' => null,
                        'sex' => $result->gender != '' ? $result->gender : null,
                        'dob' => $result->dob != '' ? $result->dob : null,
                        'age' => $result->age != '' ? $result->age : null,
                        'nationality' => $result->nationality != '' ? $result->nationality : null,
                        'client_contact' => $result->phone_number != '' ? $result->phone_number : null,
                        'village' => null,
                        'parish' => null,
                        'subcounty' => null,
                        'district' => $result->patient_district != '' ? $result->patient_district : null,
                        'nok_name' => $result->nok_name != '' ? $result->nok_name : null,
                        'nok_contact' => null,
                        'has_symptoms' => null,
                        'onset_date' => null,
                        'symptoms' => null,
                        'underlying_conditions' => null,
                        'sample_type' => $result->sample_type != '' ? $result->sample_type : null,
                        'sample_collection_date' => $result->collection_date != '' ? $result->collection_date : null,
                        'sample_identifier' => $result->lab_no != '' ? $result->lab_no : null,
                        'sample_reception_date' => $result->accessioned_at != '' ? $result->accessioned_at : null,
                        'test_date' => $result->result_added_at != '' ? $result->result_added_at : null,
                        'test_result' => $result->result != '' ? $result->result : null,
                        'ct_value' => $ct_value,
                        'platform_range' => $result->platform_range != '' ? $result->platform_range : null,
                        'testing_platform' => $result->platform != '' ? $result->platform : null,
                        'test_method' => $result->test_type != '' ? $result->test_type : null,
                        'result_approved_by' => 'Kigozi Edgar',
                        'testing_laboratory' => 'Makerere University College of Health Sciences',
                        'uploaded_by' => Auth::user()->surname.' '.Auth::user()->first_name,
                        'lis_id' => 'eyJpdiI6IlZxbXBoN3BWSFBUTjdXaW1QeE83NHc9PSIsInZhbHVlIjoiYmd3S3FkQ2MxTGIrUWExSnJsbXc2dz09IiwibWFjIjoiYjk2MDRjNjU4MDIxMmJlY2U2OGM4ZGVlODhmZjNkOTQ2NDU4NGJlNjk4OGE2NGI5OTI4ZDdlZWYxODExMjdhMyJ9',
                        'eac_lab_id' => 'eyJpdiI6IklYR1Exb3M5UjRSYzN5SjlSa1ZjNWc9PSIsInZhbHVlIjoiV1pBSHNsdURyaGp4cEJYR0t3V0t3QT09IiwibWFjIjoiMWY3NDM1N2E4MmQxMTU2OTk4ZjIwMGQ2MDUxNzViMGRhZjY1ZDg4NjE3Y2IyZDYxMWQzMDdlMTU1NjE5Yzg2ZiJ9',
                    ], ],

            ];
        });

        // return $patient;
        $client = new Client(['base_uri' => 'https://limsapi.cphluganda.org/rds_sync', 'verify' => false]);
        try {
            $res = $client->request('POST', 'https://limsapi.cphluganda.org/rds_sync', [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($patient[0]),
            ]);

            $mugonjwa->rds_success = $res->getStatusCode();
            $mugonjwa->rds_failure = null;
            $mugonjwa->update();

            return redirect()->back()->with('success', $res->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($mugonjwa->rds_success != '201') {
                $mugonjwa->rds_failure = $e->getCode();
                $mugonjwa->update();
            }

            return redirect()->back()->with('error', $e->getResponse()->getBody()->getContents());
        }
    }


    public function update_rds($id)
    {
        $data = wagonjwa::addSelect(
            [
                'collection_site' => Facility::select('facility_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'facility_type' => Facility::select('facility_type')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'requester_name' => Facility::select('requester_name')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'requester_contact' => Facility::select('requester_contact')->whereColumn('wagonjwas.facility_id', 'facilities.id'),
                'collectedby' => Swabber::select('full_name')->whereColumn('wagonjwas.collected_by', 'swabbers.id'),
                'performedby' => User::select('name')->whereColumn('wagonjwas.result_added_by', 'users.id'),
                'platform' => Platform::select('platform_name')->whereColumn('wagonjwas.platform', 'platforms.id'),
                'platform_range' => Platform::select('platform_range')->whereColumn('wagonjwas.platform', 'platforms.id'),
                'kit' => Kit::select('kit_name')->whereColumn('wagonjwas.test_kit', 'kits.id'),

            ]
        )->where(['id' => $id, 'status' => 'Completed'])
        //->whereNull('rds_success')
        ->get();

        $mugonjwa = wagonjwa::findOrFail($id);
        $doseCount = '';
        $ct_value = '';
        //return $mugonjwa;

        $patient = $data->map(function ($result) {
            if ($result->vaccine_dose1 == null && $result->vaccine_dose2 == null && $result->vaccine_dose3 == null) {
                $doseCount = 0;
            } elseif ($result->vaccine_dose1 && $result->vaccine_dose2 == null && $result->vaccine_dose3 == null) {
                $doseCount = 1;
            } elseif ($result->vaccine_dose1 && $result->vaccine_dose2 && $result->vaccine_dose3 == null) {
                $doseCount = 2;
            } elseif ($result->vaccine_dose1 && $result->vaccine_dose3 && $result->vaccine_dose2 == null) {
                $doseCount = 2;
            } elseif ($result->vaccine_dose1 && $result->vaccine_dose2 && $result->vaccine_dose3) {
                $doseCount = 3;
            } else {
                $doseCount = 0;
            }
            $ct_value = $result->target1.'=0.000';
            $confirmatory_value = $result->ct_value > 0 && $result->ct_value < 38 ? '='.$result->ct_value : '=0.000';

            if ($result->target1 != null && $result->target2 != null && $result->target3 != null && $result->target4 != null &&
            $result->ct_value != null && $result->ct_value2 != null && $result->ct_value3 != null && $result->ct_value4 != null) {
                $ct_value = $result->target1.$confirmatory_value.' '.$result->target2.'='.$result->ct_value2.' '.$result->target3.'='.$result->ct_value3.' '.$result->target4.'='.$result->ct_value4;
            } elseif ($result->target1 != null && $result->target2 != null && $result->target3 != null && $result->target4 == null &&
            $result->ct_value != null && $result->ct_value2 != null && $result->ct_value3 != null && $result->ct_value4 == null) {
                $ct_value = $result->target1.$confirmatory_value.' '.$result->target2.'='.$result->ct_value2.' '.$result->target3.'='.$result->ct_value3;
            } elseif ($result->target1 != null && $result->target2 != null && $result->target3 == null && $result->target4 == null && $result->ct_value != null && $result->ct_value2 != null && $result->ct_value3 == null && $result->ct_value4 == null) {
                $ct_value = $result->target1.$confirmatory_value.' '.$result->target2.'='.$result->ct_value2;
            } elseif (
                $result->target1 != null && $result->target2 == null && $result->target3 == null && $result->target4 == null &&
                $result->ct_value != null && $result->ct_value2 == null && $result->ct_value3 == null && $result->ct_value4 == null) {
                $ct_value = $result->target1.$confirmatory_value;
            } else {
                if ($result->result == 'Negative') {
                    $ct_value = $result->target1.'=0.000';
                }
            }
            // if($result->result=='Negative'){
            //     $ct_value="0.000";
            // }

            return [
                'token' => 'aYo423aVqXhKnG2QI6fcsPLyBmB0ONSLlOcWTkY8Jm9BEgA10y0AtiM',
                'result' => [
                    [

                        'specimen_uuid'=>$result->sample_id,
                        // 'lis_id'=>"eyJpdiI6Im1Ca3ljNjFDVW5ISU1qNCtmd0M2elE9PSIsInZhbHVlIjoiK2ZHNFB5V3ordTZpM21yMlNaVHcwZz09IiwibWFjIjoiOTRmMDg1NzhkZjQxMWQ1ZTM4NTE1MWI0ZmM4YTliYjk2MmE2M2Q4NzA5MmJiNGM2M2M2MzM2M2NmMmVmM2JhZCJ9",
                        // 'eac_lab_id'=>"eyJpdiI6IlYzUzNNcVpWc2RHQzQ5XC90aDNUM25RPT0iLCJ2YWx1ZSI6IlJSZUJwZmxZZWRRTzVcL2tMM2hiUGV3PT0iLCJtYWMiOiJkMzhkNTQ1ZDEyZTYxNzA2ZDU4NGZhMmU2ZDA3NWZjZjYwOTc4N2ZhNzYyYWZmOTk0Y2UzYzFjN2QyMmNjNGU4In0=",

                        'lis_id' => 'eyJpdiI6IlZxbXBoN3BWSFBUTjdXaW1QeE83NHc9PSIsInZhbHVlIjoiYmd3S3FkQ2MxTGIrUWExSnJsbXc2dz09IiwibWFjIjoiYjk2MDRjNjU4MDIxMmJlY2U2OGM4ZGVlODhmZjNkOTQ2NDU4NGJlNjk4OGE2NGI5OTI4ZDdlZWYxODExMjdhMyJ9',
                        'eac_lab_id' => 'eyJpdiI6IklYR1Exb3M5UjRSYzN5SjlSa1ZjNWc9PSIsInZhbHVlIjoiV1pBSHNsdURyaGp4cEJYR0t3V0t3QT09IiwibWFjIjoiMWY3NDM1N2E4MmQxMTU2OTk4ZjIwMGQ2MDUxNzViMGRhZjY1ZDg4NjE3Y2IyZDYxMWQzMDdlMTU1NjE5Yzg2ZiJ9',

                        'specimen_lab_id'=> $result->lab_no != '' ? $result->lab_no : null,
                        'ct_value' => $ct_value,
                        'result' => $result->result != '' ? $result->result : null,
                        'test_date' => $result->result_added_at != '' ? $result->result_added_at : null,
                        'platform_range' => $result->platform_range != '' ? $result->platform_range : null,
                        'testing_platform' =>  $result->platform != '' ? $result->platform : null,
                        'test_method' => $result->test_type != '' ? $result->test_type : null,
                        'tested_by' =>  $result->performedby != '' ? $result->performedby : null,
                        'uploaded_by'  => 'Makerere University College of Health Sciences',
                        'approved_by' => "Lwanga Newton",
                    ], ],

            ];
        });

        // return $patient[0];
        // return $patient;
        $client = new Client(['base_uri' => 'https://limsapi.cphluganda.org/sync/results', 'verify' => false]);
        try {
            $res = $client->request('POST', 'https://limsapi.cphluganda.org/sync/results', [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($patient[0]),
            ]);

            $mugonjwa->rds_success = $res->getStatusCode();
            $mugonjwa->rds_failure = null;
            $mugonjwa->update();

            return redirect()->back()->with('success', $res->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($mugonjwa->rds_success != '201') {
                $mugonjwa->rds_failure = $e->getCode();
                $mugonjwa->update();
            }

            return redirect()->back()->with('error', $e->getResponse()->getBody()->getContents());
        }
    }
}
