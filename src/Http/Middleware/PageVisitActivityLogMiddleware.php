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

        $log = activityLog()->useLog('Page Visits')->causedBy($user)->event('Page Visit')->performedOn($user);
        $description = $user->name() . ' visited: ' . $request->path() . ' at ' . now()->toDateTimeString();

        dispatch(fn () => $log->log($description))->name('page-visit-activity-log');

        return $response;
    }
}
