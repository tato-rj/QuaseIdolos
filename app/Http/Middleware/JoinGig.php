<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Gig;

class JoinGig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && ! auth()->user()->gig()->exists()) {
            if (! Gig::ready()->live()->exists())
                return $next($request);

            $gigs = Gig::ready();
            
            auth()->user()->tryToJoin($gigs);

            if($gigs->count() > 1 || ! $gigs->exists() || ! $gigs->first()->isLive())
                return redirect(route('gig.select', ['origin' => $this->getOrigin($request)]));
        }

        return $next($request);
    }

    public function getOrigin($request)
    {
        if ($request->origin)
            return $request->origin;

        if ($request->method() == 'GET')
            return url()->current();

        return url()->previous();
    }
}
