<?php

namespace App\Http\Controllers;

use App\Models\CRS\Tat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientRegController extends Controller
{
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
            $query->select(DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'),
            DB::raw("DATE_FORMAT(DateCreated, '%Y-%m-%d') new_date"))
            ->groupBy('new_date')->orderBy('new_date', 'DESC');
        })
        ->when($request->group == 'Weekly', function ($query) use ($request) {
            $query->select('WeekCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })
        ->when($request->group == 'Monthly', function ($query) use ($request) {
            $query->select('MonthCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($request->group == 'Yearly', function ($query) use ($request) {
            $query->select('YearCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();

        $data['meanData'] = Tat::whereNotNull('result')->limit(12)
        ->when($request->group == null, function ($query) use ($request) {
            $query->select(DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'),
            DB::raw("DATE_FORMAT(DateCreated, '%Y-%m-%d') new_date"))
            ->groupBy('new_date')->orderBy('new_date', 'DESC');
        })
        ->when($request->group == 'Weekly', function ($query) use ($request) {
            $query->select('WeekCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })
        ->when($request->group == 'Monthly', function ($query) use ($request) {
            $query->select('MonthCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($request->group == 'Yearly', function ($query) use ($request) {
            $query->select('YearCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();

      

  
        $data['title']=$request->group!= '' ? $request->group : 'Daily';
    
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('crs.cov_mdb.labReportTAT', $data);
    }

    public function tatPropotion(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
     
        if ($request->group == null){
        $data['propotions'] =  DB::select(DB::raw('SELECT DateCreated as new_date, 
            count(*) as total, 
            count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
            count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
            from Tat_Per_Entry_Old WHERE Result IS NOT NULL
            GROUP BY DateCreated
            ORDER BY DateCreated DESC LIMIT 360'));  
        $data['ChartData'] =  DB::select(DB::raw('SELECT DateCreated as new_date, 
            count(*) as total, 
            count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
            count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
            from Tat_Per_Entry_Old WHERE Result IS NOT NULL
            GROUP BY DateCreated
            ORDER BY DateCreated DESC LIMIT 12'));    
        }
        if ($request->group == 'Weekly'){
            $data['propotions'] =  DB::select(DB::raw('SELECT WeekCreated as new_date, 
                count(*) as total, 
                count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                from Tat_Per_Entry_Old WHERE Result IS NOT NULL
                GROUP BY WeekCreated
                ORDER BY WeekCreated DESC LIMIT 360'));  
            $data['ChartData'] =  DB::select(DB::raw('SELECT DateCreated as new_date, 
                count(*) as total, 
                count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                from Tat_Per_Entry_Old WHERE Result IS NOT NULL
                GROUP BY WeekCreated
                ORDER BY WeekCreated DESC LIMIT 12'));    
            }
            if ($request->group == 'Monthly'){
                $data['propotions'] =  DB::select(DB::raw('SELECT MonthCreated as new_date, 
                    count(*) as total, 
                    count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                    count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                    from Tat_Per_Entry_Old WHERE Result IS NOT NULL
                    GROUP BY MonthCreated
                    ORDER BY MonthCreated DESC LIMIT 360'));  
                $data['ChartData'] =  DB::select(DB::raw('SELECT MonthCreated as new_date, 
                    count(*) as total, 
                    count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                    count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                    from Tat_Per_Entry_Old WHERE Result IS NOT NULL
                    GROUP BY MonthCreated
                    ORDER BY MonthCreated DESC LIMIT 12'));    
                }
                if ($request->group == 'Yearly'){
                    $data['propotions'] =  DB::select(DB::raw('SELECT YearCreated as new_date, 
                        count(*) as total, 
                        count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                        count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                        from Tat_Per_Entry_Old WHERE Result IS NOT NULL
                        GROUP BY YearCreated
                        ORDER BY YearCreated DESC LIMIT 360'));  
                    $data['ChartData'] =  DB::select(DB::raw('SELECT YearCreated as new_date, 
                        count(*) as total, 
                        count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                        count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                        from Tat_Per_Entry_Old WHERE Result IS NOT NULL
                        GROUP BY YearCreated
                        ORDER BY YearCreated DESC LIMIT 12'));    
                    }
        $data['title']=$request->group!= '' ? $request->group : 'Daily';
    
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('crs.cov_mdb.labReportTatPropotion', $data);
    }

    public function tatRange(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
       

        $data['rangeTat'] =  Tat::whereNotNull('result')
        ->when($request->group == null, function ($query) use ($request) {
            $query->select('DateCreated as new_date',
            DB::raw('MIN(EntryToResult) AS MinMins, MAX(EntryToResult) AS MaxMins'))
            ->orderBy('DateCreated', 'DESC')->groupBy('DateCreated');
        })
        ->when($request->group == 'Weekly', function ($query) use ($request) {
            $query->select('WeekCreated as new_date',
            DB::raw('MIN(EntryToResult) AS MinMins, MAX(EntryToResult) AS MaxMins'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })      
        ->when($request->group == 'Monthly', function ($query) use ($request) {
            $query->select('MonthCreated as new_date',
            DB::raw('MIN(EntryToResult) AS MinMins, MAX(EntryToResult) AS MaxMins'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($request->group == 'Yearly', function ($query) use ($request) {
            $query->select('YearCreated as new_date',
            DB::raw('MIN(EntryToResult) AS MinMins, MAX(EntryToResult) AS MaxMins'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();

        $data['rangeChartData'] = Tat::whereNotNull('result')->limit(12)
        ->when($request->group == null, function ($query) use ($request) {
            $query->select('DateCreated as new_date',
            DB::raw('MIN(EntryToResult) AS MinMins, MAX(EntryToResult) AS MaxMins'))
            ->orderBy('DateCreated', 'DESC')->groupBy('DateCreated');
        })
        ->when($request->group == 'Weekly', function ($query) use ($request) {
            $query->select('WeekCreated as new_date',
            DB::raw('MIN(EntryToResult) AS MinMins, MAX(EntryToResult) AS MaxMins'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })      
        ->when($request->group == 'Monthly', function ($query) use ($request) {
            $query->select('MonthCreated as new_date',
            DB::raw('MIN(EntryToResult) AS MinMins, MAX(EntryToResult) AS MaxMins'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($request->group == 'Yearly', function ($query) use ($request) {
            $query->select('YearCreated as new_date',
            DB::raw('MIN(EntryToResult) AS MinMins, MAX(EntryToResult) AS MaxMins'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();    
        $data['title']=$request->group!= '' ? $request->group : 'Daily';
    
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('crs.cov_mdb.labReportTatRange', $data);
    }

}
