<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Song, SongRequest};
use App\Events\{SongRequested, SongFinished, SongCancelled};
use App\Http\Requests\{SongRequestForm, ChangeSongRequestForm};

class SongRequestsController extends Controller
{
    public function store(Request $request, Song $song, SongRequestForm $form)
    {
        $songRequest = auth()->user()->liveGig->withSetlistLock(function ($gig) use ($request, $song, $form) {
            auth()->user()->liveGig = $gig;

            // Another request may have filled or closed the event while we waited.
            if (! $form->authorize())
                $form->failedAuthorization();

            $songRequest = (new SongRequest)->add(auth()->user(), $song, $gig, $request->user_name);
            $songRequest->setRelation('gig', $gig);
            $songRequest->inviteMany($request->input('participants', []));

            if ($request->has('recommended'))
                $songRequest->update(['was_recommended' => true]);

            return $songRequest;
        });

        try {
            SongRequested::dispatch($songRequest);
        } catch (\Exception $e) {
            report($e);
        }

        return back()->with('success', 'O seu nome está na lista, vai se preparando!');
    }

    public function update(Request $request, SongRequest $songRequest, ChangeSongRequestForm $form)
    {
        $songRequest = $songRequest->gig->withSetlistLock(function ($gig) use ($songRequest, $form) {
            $current = $gig->setlist()->findOrFail($songRequest->id);
            $form->route()->setParameter('songRequest', $current);

            if (auth()->user()->liveGig && auth()->user()->liveGig->is($gig))
                auth()->user()->liveGig = $gig;

            if (! $form->authorize())
                $form->failedAuthorization();

            $current->update(['song_id' => $form->getSong()->id]);
            $current->setRelation('gig', $gig);

            return $current;
        });

        try {
            SongRequested::dispatch($songRequest);
        } catch (\Exception $e) {
            bugreport($e);
        }
        
        return back()->with('success', 'O seu pedido foi modificado com sucesso');
    }

    public function alert()
    {
        if (auth()->user()->admin()->exists())
            return;

        $songRequests = auth()->user()->songRequests()->forGig(auth()->user()->liveGig)->waiting()
            ->with('invitations.user')->get();
        $invitations = auth()->user()->invitations()->confirmed()->forGig(auth()->user()->liveGig)->waiting()
            ->with(['songRequest.song', 'songRequest.user', 'songRequest.invitations.user'])->get();

        $songRequests = $songRequests->merge($invitations->pluck('songRequest'));

        if (! $songRequests->isEmpty())
            return view('pages.setlists.user.banner.index', compact('songRequests'))->render();
    }

    public function finish($id)
    {
        $songRequest = SongRequest::find($id);
        
        if (! $songRequest)
            return back();

        $this->authorize('update', $songRequest);

        $songRequest = $songRequest->gig->withSetlistLock(function ($gig) use ($id) {
            $current = $gig->setlist()->find($id);

            if (! $current || $current->isOver())
                return null;

            $current->setRelation('gig', $gig);
            $current->finish();
            $gig->updateSet(false);
            $current->invitations()->update(['confirmed_at' => now()]);
            $gig->sortSetlist();

            return $current;
        });

        if (! $songRequest)
            return back();
        
        try {
            SongFinished::dispatch($songRequest);
        } catch (\Exception $e) {
            bugreport($e);
        }

        return back()->with('success', 'O pedido foi completado com sucesso');
    }

    public function cancel($id)
    {        
        $songRequest = SongRequest::find($id);

        if (! $songRequest || $songRequest->isOver())
            return back();

        $this->authorize('update', $songRequest);

        $songRequest = $songRequest->gig->withSetlistLock(function ($gig) use ($id) {
            $current = $gig->setlist()->find($id);

            if (! $current || $current->isOver())
                return null;

            $current->setRelation('gig', $gig);
            $current->load('song');
            $current->cancel();
            $gig->updateSet(true);
            $gig->sortSetlist();

            return $current;
        });

        if (! $songRequest)
            return back();

        try {
            SongCancelled::dispatch($songRequest);
        } catch (\Exception $e) {
            report($e);
        }

        return back()->with('success', 'O pedido foi cancelado com sucesso');
    }
}
