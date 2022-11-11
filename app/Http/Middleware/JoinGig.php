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
            $gigs = Gig::ready();

            if($gigs->count() == 1)
                auth()->user()->join($gigs->first());

            if($gigs->count() > 1 || ! $gigs->exists())
                return redirect(route('gig.select'));
        }

        return $next($request);
    }
}
