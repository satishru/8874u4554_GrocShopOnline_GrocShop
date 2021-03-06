<?php

namespace GroceryApp\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        //if (! $request->expectsJson()) {
        if (! ($request->expectsJson() || !collect($request->route()->middleware())->contains('api'))) {
            return route('login');
        }
    }
}
