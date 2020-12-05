<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserActive
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
      if (\Auth::check()) {
          // The user is logged in...
          $user = \Auth::user();
          $user->last_activity = date('Y-m-d H:i:s');
          $user->save();
      }
      return $next($request);
    }
}
