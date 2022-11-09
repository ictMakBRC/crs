<?php


namespace App\Helpers;
use Request;
// use Jenssegers\Agent\Facades\Agent;
use App\Models\CRS\ActivityTrail as ActivityTrailModel;

class ActivityTrail
{
    public static function addToTrail($user_id,$patient_id,$lab_no,$event)
    {   
    	$trail = [];
        // $platform=Agent::platform();
        // $browser=Agent::browser();
        
    	$trail['user_id'] = $user_id;
        $trail['wagonjwa_id'] = $patient_id;
        $trail['lab_no'] = $lab_no;
        $trail['event'] = $event;
        // $trail['name'] = $browser;
    	// $trail['url'] = Request::fullUrl();
    	// $trail['method'] = Request::method();
    	
    	ActivityTrailModel::create($trail);
    }

    public static function activityTrailLists()
    {
    	return ActivityTrailModel::latest()->get();
    }

}