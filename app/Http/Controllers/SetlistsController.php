<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Gig, SongRequest, Admin};
use App\Events\SetlistReordered;

class SetlistsController extends Controller
{
    public function admin()
    {
        $gig = auth()->user()->liveGig;

        if ($gig)
            $this->authorize('viewSetlist', $gig);

        $setlist = $gig ? $gig->setlist()->orderBy('order')->get() : collect();
        $musicians = Admin::musicians()->get();

        return view('pages.setlists.admin.index', compact(['setlist', 'gig', 'musicians']));
    }

    public function table(Request $request)
    {
        if ($request->has('newOrder')) {
            $this->authorize('reorder', auth()->user()->liveGig);

            foreach($request->newOrder as $data) {
                $set = json_decode($data);
                if ($songRequest = SongRequest::find($set->id))
                    $songRequest->update(['order' => $set->order]);
            }

            try {
                SetlistReordered::dispatch(auth()->user()->liveGig);
            } catch (\Exception $e) {
                bugreport($e);
            }
        }

        $gig = auth()->user()->liveGig;
        $setlist = $gig->setlist()->orderBy('order')->get();
        $percentage = percentage($setlist->count(), $gig->songs_limit);

        return view('pages.setlists.admin.table', compact(['setlist', 'percentage', 'gig']))->render();
    }

    public function user()
    {
        $pastList = auth()->user()->requestsSung()->paginate(8);

        $groupList = auth()->user()->invitationsSung()->paginate(8);

        $waitingList = auth()->user()->requestsWaiting();

        return view('pages.setlists.user.index', compact(['pastList', 'waitingList', 'groupList']));    
    }
}
