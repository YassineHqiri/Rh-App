<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckHrRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->hasHrAccess()) {
            abort(403, 'Unauthorized. HR access required.');
        }

        return $next($request);
    }
}
