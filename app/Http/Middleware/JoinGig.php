<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Gig;

class JoinGig
{
    protected $withModal = [
        'cardapio.index',
        'favorites.index'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        session()->forget('origin');

        if (auth()->check() && ! auth()->user()->gig()->live()->exists()) {
            if (! Gig::ready()->live()->exists())
                return $next($request);

            $gigs = Gig::ready();

            $modal = auth()->user()->tryToJoin($gigs);

            if ($gigs->count() == 1 && $gigs->first()->password()->required()) {
                if ($this->shouldReturn($request))
                    return redirect($this->getOrigin($request))->with('modal', $modal ?? 'pages.gigs.modals.select');

                session()->flash('modal', $modal);
            }

            if ($gigs->count() > 1 || ! $gigs->exists() || ! $gigs->first()->isLive()) {
                if ($this->wantsModal() && $this->shouldReturn($request))
                    return redirect($this->getOrigin($request))->with('modal', $modal ?? 'pages.gigs.modals.select');

                return redirect(route('gig.select', ['origin' => $this->getOrigin($request)]));
            }
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

    public function wantsModal()
    {
        foreach($this->withModal as $routename) {
            if (simpleUrl(url()->previous()) == route($routename)) {
                return true;
            }   
        }
    }

    public function shouldReturn($request)
    {
        return $this->getOrigin($request) == url()->previous();
    }
}
