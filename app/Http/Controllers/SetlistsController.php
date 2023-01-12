<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Gig, SongRequest};

class SetlistsController extends Controller
{
    public function admin()
    {
        $gig = auth()->user()->liveGig;
        $setlist = $gig ? $gig->setlist()->orderBy('order')->get() : collect();

        return view('pages.setlists.admin.index', compact(['setlist', 'gig']));
    }

    public function table(Request $request)
    {
        if ($request->has('newOrder')) {
            foreach($request->newOrder as $data) {
                $set = json_decode($data);
                SongRequest::find($set->id)->update(['order' => $set->order]);
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
        $waitingList = auth()->user()->requestsWaiting();

        return view('pages.setlists.user.index', compact(['pastList', 'waitingList']));    
    }
}
