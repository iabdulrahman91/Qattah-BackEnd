<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Owner
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->id == $request->purchase->user_id) {
            return $next($request);
        }
        return response()
            ->json(['message' => 'Forbidden'])
            ->setStatusCode(403);


    }
}
