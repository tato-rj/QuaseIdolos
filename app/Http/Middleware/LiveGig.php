<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\{Gig, Venue};

class LiveGig
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
        if (auth()->check()) {
            $this->checkSubdomain();
            auth()->user()->checkLiveGig();
        }

        return $next($request);
    }

    public function checkSubdomain()
    {
        if ($gigs = Gig::inSubdomain()->ready()) {
            $modal = auth()->user()->forceJoin($gigs);

            if ($gigs->count() == 1 && $gigs->first()->password()->required())
                session()->flash('modal', $modal);
        }
    }
}
