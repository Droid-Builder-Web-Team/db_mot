<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCodeOfConduct
{
    public function handle(Request $request, Closure $next): Response
    {

        $user = auth()->user();
        if (!auth()->check() || $request->is('codeofconduct*', 'verify*', 'logout')) {
            return $next($request);
        }
    
        // 2. IMPORTANT: If they haven't accepted GDPR yet, let the GDPR middleware handle it.
        // Do NOT redirect to CoC yet.
        if ($user->accepted_gdpr == NULL) {
            return $next($request);
        }
    
        // 3. If they HAVE accepted GDPR but NOT the CoC, send them to CoC.
        if ($user->accepted_coc == 0) {
            return redirect()->route('codeofconduct'); // Use named routes where possible
        }
    
        return $next($request);
    }
}
