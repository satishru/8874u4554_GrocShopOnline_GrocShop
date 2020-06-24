<?php

namespace GroceryApp\Http\Middleware;
use Illuminate\Http\Request;

use Closure;

class GuestApiMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $API_KEY = \Config::get('constants.API_KEY');

        $request->headers->set('Accept', 'application/json');
        if($request->api_key != $API_KEY) {
            $arrayData['error_code'] = \Config::get('constants.error_code.FIELD_ERROR');
            $arrayData['error_message'] = "Invalid Api Key";
            $arrayData['error_info'] = [];
            return response()->json($arrayData);
        }
        return $next($request);
    }
}
