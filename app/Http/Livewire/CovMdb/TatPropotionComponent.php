<?php

namespace App\Http\Livewire\CovMdb;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class TatPropotionComponent extends Component
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
    public function render()
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
     
        if ($this->group == null){
        $data['propotions'] =  DB::select(DB::raw('SELECT DateCreated as new_date, 
            count(*) as total, 
            count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
            count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
            from  Tat_Per_Entry_Old WHERE Result IS NOT NULL
            GROUP BY DateCreated
            ORDER BY DateCreated DESC LIMIT 360'));  
        $data['ChartData'] =  DB::select(DB::raw('SELECT DateCreated as new_date, 
            count(*) as total, 
            count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
            count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
            from  Tat_Per_Entry_Old WHERE Result IS NOT NULL
            GROUP BY DateCreated
            ORDER BY DateCreated DESC LIMIT 12'));    
        }
        if ($this->group == 'Weekly'){
            $data['propotions'] =  DB::select(DB::raw('SELECT WeekCreated as new_date, 
                count(*) as total, 
                count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                from  Tat_Per_Entry_Old WHERE Result IS NOT NULL
                GROUP BY WeekCreated
                ORDER BY WeekCreated DESC LIMIT 360'));  
            $data['ChartData'] =  DB::select(DB::raw('SELECT DateCreated as new_date, 
                count(*) as total, 
                count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                from  Tat_Per_Entry_Old WHERE Result IS NOT NULL
                GROUP BY WeekCreated
                ORDER BY WeekCreated DESC LIMIT 12'));    
            }
            if ($this->group == 'Monthly'){
                $data['propotions'] =  DB::select(DB::raw('SELECT MonthCreated as new_date, 
                    count(*) as total, 
                    count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                    count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                    from  Tat_Per_Entry_Old WHERE Result IS NOT NULL
                    GROUP BY MonthCreated
                    ORDER BY MonthCreated DESC LIMIT 360'));  
                $data['ChartData'] =  DB::select(DB::raw('SELECT MonthCreated as new_date, 
                    count(*) as total, 
                    count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                    count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                    from  Tat_Per_Entry_Old WHERE Result IS NOT NULL
                    GROUP BY MonthCreated
                    ORDER BY MonthCreated DESC LIMIT 12'));    
                }
                if ($this->group == 'Yearly'){
                    $data['propotions'] =  DB::select(DB::raw('SELECT YearCreated as new_date, 
                        count(*) as total, 
                        count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                        count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                        from  Tat_Per_Entry_Old WHERE Result IS NOT NULL
                        GROUP BY YearCreated
                        ORDER BY YearCreated DESC LIMIT 360'));  
                    $data['ChartData'] =  DB::select(DB::raw('SELECT YearCreated as new_date, 
                        count(*) as total, 
                        count(if(EntryToResult < 1441, 11, NULL)) as totalwitin, 
                        count(if(EntryToResult > 1440, 13, NULL)) as totalOut 
                        from  Tat_Per_Entry_Old WHERE Result IS NOT NULL
                        GROUP BY YearCreated
                        ORDER BY YearCreated DESC LIMIT 12'));    
                    }
                    $data['title']=$this->group!= '' ? $this->group : 'Daily';
    
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('livewire.cov-mdb.tat-propotion-component', $data)->layout('crs.layouts.app');
    }

}
