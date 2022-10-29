<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Gig, SongRequest};

class SetlistsController extends Controller
{
    public function admin()
    {
        $gig = Gig::live()->first();
        $setlist = SongRequest::waiting()->get();

        return view('pages.setlists.admin.show', compact(['setlist', 'gig']));
    }

    public function table(Request $request)
    {
        if ($request->has('newOrder')) {
            foreach($request->newOrder as $data) {
                $set = json_decode($data);
                SongRequest::find($set->id)->update(['order' => $set->order]);
            }
        }

        $setlist = SongRequest::waiting()->get();

        return view('pages.setlists.admin.table', compact('setlist'))->render();
    }

    public function user()
    {
        $pastList = auth()->user()->requestsSung();
        $waitingList = auth()->user()->requestsWaiting();

        return view('pages.setlists.user.show', compact(['pastList', 'waitingList']));    
    }
}
