<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Gig, SongRequest};

class SetlistsController extends Controller
{
    public function admin()
    {
        $gig = liveGig();
        $setlist = $gig ? $gig->setlist()->waiting()->get() : collect();
        $percentage = percentage($setlist->count(), $gig ? $gig->songs_limit : 0);

        return view('pages.setlists.admin.show', compact(['setlist', 'gig', 'percentage']));
    }

    public function table(Request $request)
    {
        if ($request->has('newOrder')) {
            foreach($request->newOrder as $data) {
                $set = json_decode($data);
                SongRequest::find($set->id)->update(['order' => $set->order]);
            }
        }

        $gig = liveGig();
        $setlist = $gig->setlist()->waiting()->get();
        $percentage = percentage($setlist->count(), $gig->songs_limit);

        return view('pages.setlists.admin.table', compact(['setlist', 'percentage', 'gig']))->render();
    }

    public function user()
    {
        $pastList = auth()->user()->requestsSung();
        $waitingList = auth()->user()->requestsWaiting();

        return view('pages.setlists.user.show', compact(['pastList', 'waitingList']));    
    }
}
