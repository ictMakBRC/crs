<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
//     public function handle($request, Closure $next)
// {
//     if ($request->route('companyID')) {
//         $company = Company::find($request->route('companyID'));
//         if ($company && $company->user_id != auth()->user()->id) {
//             return redirect('/');
//         }
//     }

//     return $next($request);
// }
}
