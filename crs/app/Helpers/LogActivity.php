<?php


namespace App\Helpers;
use Request;
use Jenssegers\Agent\Facades\Agent;
use App\Models\ActivityLog as LogActivityModel;;

class LogActivity
{
    public static function addToLogOld($description,$email,$ip)
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

    public static function addToLog($description, $email, $ip)
{
    $log = [];
    $platform = Agent::platform();
    $browser = Agent::browser();
    
    // Cross-platform MAC address solution
    $macAddr = 'unknown';
    try {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows
            $macAddr = shell_exec('getmac');
        } else {
            // Linux/Unix/Mac
            $macAddr = shell_exec("netstat -ie | grep -o -E '([[:xdigit:]]{1,2}:){5}[[:xdigit:]]{1,2}'");
        }
    } catch (\Exception $e) {
        // Fallback if MAC address cannot be retrieved
        $macAddr = 'unavailable';
    }

    $log['user_id'] = auth()->check() ? auth()->user()->id : null;
    $log['email'] = $email;
    $log['description'] = $description;
    $log['platform'] = $platform;
    $log['browser'] = $browser;
    $log['mac'] = $macAddr;
    $log['client_ip'] = $ip;
    
    LogActivityModel::create($log);
}

    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }

}
