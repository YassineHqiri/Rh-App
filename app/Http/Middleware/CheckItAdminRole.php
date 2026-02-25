<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckItAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->is_active || !$user->isItAdmin()) {
            abort(403, 'Unauthorized. IT admin access required.');
        }

        return $next($request);
    }
}
