<?php

namespace Atendwa\Msingi\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PageVisitActivityLogMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (! $user) {
            return $next($request);
        }

        $response = $next($request);

        \Illuminate\Support\defer(function () use ($request, $user): void {
            activity()->useLog('Page Visits')->causedBy($user)->event('Page Visit')->performedOn($user)
                ->withProperties([
                    'user_agent' => $request->userAgent(),
                    'attributes' => $request->collect(),
                    'ip_address' => $request->ip(),
                    'path' => $request->path(),
                ])
                ->log($user->name() . ' visited: ' . $request->path() . ' at ' . now()->toDateTimeString());
        });

        return $response;
    }
}
