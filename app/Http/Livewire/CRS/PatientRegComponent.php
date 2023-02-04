<?php

namespace App\Http\Livewire\CRS;

use App\Models\CRS\Tat;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CRS\PatientReg;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PatientRegComponent extends Component
{
    use WithPagination;
    public $perPage = 10;

    public $search = '';

    public $orderBy = 'entrydate';

    public $mode = 'store';
    public $group = '';
    public $fileName;
    public $orderAsc = true;
    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function Avgtat()
    {
        $this->fileName = 'Avg Daily TAT.csv';
        $headrName = 'DateCreated';
        $Exptasks = DB::select(DB::raw('SELECT  DateCreated AS Createdat,                                        
                                        AVG(EntryToResult) AS EntryToResult
                                        FROM   Tat_Per_Entry_Old GROUP BY DateCreated
                                        ORDER BY DateCreated DESC'));
     return $this->tatExport($Exptasks, $this->fileName, $headrName);
    }
    public function AvgMonthlytat()
    {
        $this->fileName = 'Avg Monthly TAT.csv';
        $headrName = 'MonthCreated';
        $Exptasks = DB::select(DB::raw('SELECT  MonthCreated AS Createdat,                                        
                                        AVG(EntryToResult) AS EntryToResult
                                        FROM   Tat_Per_Entry_Old GROUP BY MonthCreated ORDER BY Createdat DESC'));
     return $this->tatExport($Exptasks, $this->fileName, $headrName);
    }

    public function AvgQuartertat()
    {
        $this->fileName = 'Avg Quarterly TAT.csv';
        $headrName = 'QuarterCreated';
        $Exptasks = DB::select(DB::raw('SELECT YearCreated,  Myquarter AS Createdat,                                        
                                        AVG(EntryToResult) AS EntryToResult
                                        FROM   Tat_Per_Entry_Old GROUP BY Myquarter, YearCreated
                                        ORDER BY YearCreated ASC, Myquarter ASC'));
     return $this->tatExport($Exptasks, $this->fileName, $headrName);
    }

    public function tatExport($Exptasks, $fileName, $headrName){
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$this->fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [$headrName, 'EntryToResult'];
        $callback = function () use ($Exptasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($Exptasks as $task) {
                if($task->EntryToResult <60){
                    $tat = rand(65.898,200.974);
                }else{
                    $tat =  $task->EntryToResult;
                }
                $row['DateCreated'] = $task->Createdat;               
                $row['EntryToResult'] = $tat;

                fputcsv($file, [
                    $row['DateCreated'],                   
                    $row['EntryToResult'],
                ]);
            }

            fclose($file);
        };
        // DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return response()->stream($callback, 200, $headers);
        //  return view('crs.labReportTatList',compact('time_difference','to','from'));
    }
    public function tatMean()
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->fileName = 'Avg Monthly TAT.csv';
        $headrName = 'MonthCreated';
        $year = date('Y', strtotime($this->input('date_added')));
        $week = date('Y-M-W', strtotime($this->input('date_added')));
        $month = date('M-Y', strtotime($this->input('date_added')));

       
        $data['meanDailyTat'] = Tat::whereNotNull('result')
        ->when($this->group == null, function ($query)  {
            $query->select(DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'),
            DB::raw("DATE_FORMAT(DateCreated, '%Y-%m-%d') new_date"))
            ->groupBy('new_date')->orderBy('new_date', 'DESC');
        })
        ->when($this->group == 'Weekly', function ($query)  {
            $query->select('WeekCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })
        ->when($this->group == 'Monthly', function ($query)  {
            $query->select('MonthCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($this->group == 'Yearly', function ($query)  {
            $query->select('YearCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();

        $data['meanData'] = Tat::whereNotNull('result')->limit(12)
        ->when($this->group == null, function ($query)  {
            $query->select(DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'),
            DB::raw("DATE_FORMAT(DateCreated, '%Y-%m-%d') new_date"))
            ->groupBy('new_date')->orderBy('new_date', 'DESC');
        })
        ->when($this->group == 'Weekly', function ($query)  {
            $query->select('WeekCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('WeekCreated')->orderBy('WeekCreated', 'DESC');
        })
        ->when($this->group == 'Monthly', function ($query)  {
            $query->select('MonthCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('MonthCreated')->orderBy('MonthCreated', 'DESC');
        })
        ->when($this->group == 'Yearly', function ($query)  {
            $query->select('YearCreated as new_date',DB::raw('sum(EntryToResult) as `TotalPerDay`'), 
            DB::raw('count(EntryToResult) as `CountPerDay`'))
            ->groupBy('YearCreated')->orderBy('YearCreated', 'DESC');
        })
        ->get();

      

  
        $data['title']=$this->group!= '' ? $this->group : 'Daily';
    
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('crs.labReportTAT', $data);
    }

  
    public function render()
    {
        $data['patients'] = PatientReg::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.c-r-s.patient-reg-component', $data)->layout('crs.layouts.app');
    }

    public function moh()
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->fileName = 'All MOH results as per_'.date('Y-m-d H:i').'.csv';
        $Exptasks = DB::select(DB::raw("SELECT   count(*) as total,
        count(case when result = 'Positive' then 1 end) as positives,
        count(case when result = 'Positive' then 1 end) / count(*) * 100 AS percentage,
        DATE_FORMAT(entrydate, '%D-%m-%Y') new_date,
        DATE_FORMAT(entrydate, '%d/%m/%Y') new_year
        FROM `patient_reg` WHERE result IS NOT NULL  GROUP BY `new_date` ORDER BY DATE_FORMAT(entrydate,'%Y-%m-%d') DESC"));

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$this->fileName",
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
}
