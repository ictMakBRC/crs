<?php


namespace App\Helpers;
use Request;
use Jenssegers\Agent\Facades\Agent;
use App\Models\ActivityLog as LogActivityModel;;

class LogActivity
{
    public static function addToLog($description,$email,$ip)
    {   
    	$log = [];
        $platform=Agent::platform();
        $browser=Agent::browser();
        $macAddr = exec('getmac');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : null;
        $log['email'] = $email;
        $log['description'] = $description;
        $log['platform'] = $platform;
        $log['browser'] = $browser;
    	$log['mac'] = $macAddr;
    	// $log['method'] = Request::method();
    	$log['client_ip'] = $ip;
    	LogActivityModel::create($log);
    }

    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }

}