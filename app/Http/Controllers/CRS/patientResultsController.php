<?php

namespace App\Http\Controllers\crs;

use App\Http\Controllers\Controller;
use App\Models\CRS\Facility;
use App\Models\CRS\Swabber;
use App\Models\CRS\wagonjwa;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class patientResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub = 'd-none';
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function importBatchs()
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $imports = wagonjwa::leftJoin('users', 'wagonjwas.result_added_by', '=', 'users.id')
        ->whereNotNull('import_batch')
        ->select('*', 'wagonjwas.id as wid', 'wagonjwas.result_added_at as resultdate', DB::raw('count(lab_no) as list'))
        ->groupBy('wagonjwas.import_batch')
        ->orderBy('result_added_at', 'DESC')
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");

        return view('crs.LabImportBatch', compact('imports'));
    }

    //=======================================================All results Pending TVS Sub=======================================
    public function pending()
    {
        $sub = '';
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->whereNull('rds_success')
    ->where('status', 'Completed')
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function pendingImport($id)
    {
        $sub = '';
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->whereNull('rds_success')
    ->where('status', 'Completed')
    ->where('import_batch', $id)
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function resultImport($id)
    {
        $sub = 'd-none';
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->where('import_batch', $id)
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function results_today()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('status', 'Completed')
    ->whereNull('rds_success')
    ->whereDay('wagonjwas.created_at', '=', $today)->whereMonth('wagonjwas.created_at', date('m'))
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function results_yesterday()
    {
        $sub = '';
        $yesterday = Carbon::yesterday();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('status', 'Completed')
    ->whereNull('rds_success')
    ->whereDay('wagonjwas.accessioned_at', '=', $yesterday)
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function results_this_week()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('status', 'Completed')
    ->whereNull('rds_success')
    ->whereBetween('wagonjwas.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function results_this_month()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('status', 'Completed')
    ->whereNull('rds_success')
    ->whereMonth('wagonjwas.created_at', '=', $today)
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    //=======================================================All results TVS Sub=============================================
    public function submitted()
    {
        $sub = 'd-none';
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('rds_success', 201)
    ->where('status', 'Completed')
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function submitted_today()
    {
        $sub = 'd-none';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('rds_success', 201)
    ->where('status', 'Completed')
    ->whereDay('wagonjwas.created_at', '=', $today)->whereMonth('wagonjwas.created_at', date('m'))
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function submitted_this_week()
    {
        $sub = 'd-none';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('rds_success', 201)
    ->where('status', 'Completed')
    ->whereBetween('wagonjwas.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function submitted_this_month()
    {
        $sub = 'd-none';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('rds_success', 201)
    ->where('status', 'Completed')
    ->whereMonth('wagonjwas.created_at', '=', $today)
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    //=======================================================All completed Sub=============================================
    public function completed()
    {
        $sub = '';
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('rds_success', 202)
    ->where('status', 'Completed')
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function completed_today()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('rds_success', 202)
    ->where('status', 'Completed')
    ->whereDay('wagonjwas.created_at', '=', $today)
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function completed_this_week()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('rds_success', 202)
    ->where('status', 'Completed')
    ->whereBetween('wagonjwas.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    public function completed_this_month()
    {
        $sub = '';
        $today = Carbon::now();
        $patients = wagonjwa::orderBy('facilities.id', 'desc')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'wagonjwas.id as wid')
    ->whereNotNull('result')
    ->where('rds_success', 202)
    ->where('status', 'Completed')
    ->whereMonth('wagonjwas.created_at', '=', $today)
    ->get();

        return view('crs.labResultList', compact('patients', 'sub'));
    }

    //====================================================Print==============================================================
    public function print($id)
    {
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
        )->leftJoin('platforms', 'wagonjwas.platform', '=', 'platforms.id')
    ->leftJoin('facilities', 'wagonjwas.facility_id', '=', 'facilities.id')
    ->select('*', 'platforms.platform_range as range', 'wagonjwas.phone_number as tell')
    ->where('wagonjwas.id', $id)->get();
        wagonjwa::where('id', $id)->increment('print_count', 1);
        // return ['results'=>$results[0]];
        // $pdf = PDF::loadView('crs.patientResult',['results'=>$results]);
        // return $pdf->download('patients.pdf');
        return view('crs.patientResult', compact('results'));
    }
}
