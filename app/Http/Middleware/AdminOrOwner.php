<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOrOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (($user->id == $request->purchase->user_id) || ($user->id == $request->purchase->event->admin->id)) {
            return $next($request);
        }
        return response()
            ->json(['message' => 'Forbidden'])
            ->setStatusCode(403);

    }
}
