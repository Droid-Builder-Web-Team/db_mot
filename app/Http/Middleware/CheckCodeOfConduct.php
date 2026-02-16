<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCodeOfConduct
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if the user is logged in
        // 2. Check if they haven't accepted the CoC
        // 3. Prevent an infinite redirect loop by checking the current path
        if (auth()->check() && 
            auth()->user()->accepted_coc == 0 && 
            !$request->is('codeofconduct*')) {
            
            return redirect('codeofconduct');
        }

        return $next($request);
    }
}
