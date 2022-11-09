<?php

namespace App\Http\Controllers;

use App\Models\CRS\notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $appName = 'CRS';
        $bizcontact = '+256-70xxxxxx';
        $bizlocation = 'Makerere Kampala';
        $bizname = 'MakBRC';
        $email = 'info@brc.com.com';

        $NotItems = notification::leftJoin('facilities', 'notifications.facility_id', '=', 'facilities.id')
        ->leftJoin('users', 'notifications.user_id', '=', 'users.id')
        ->select('notifications.created_at as date', 'notifications.id as nid', 'body', 'subject', 'facility_name', 'name', 'first_name', 'avatar')->Where('state', 'All')->Where('seen', 'No')->limit(5)->get();
        $NotCount = notification::Where('state', 'All')->where('seen', 'No')->count();

        View::share('appName', $appName);
        View::share('bizcontact', $bizcontact);
        View::share('bizname', $bizname);
        View::share('bizlocation', $bizlocation);
        View::share('bizemail', $email);
        View::share('NotCount', $NotCount);
        View::share('NotItems', $NotItems);
    }
}
