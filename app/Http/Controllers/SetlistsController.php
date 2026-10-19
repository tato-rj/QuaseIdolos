<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Events\SetlistReordered;

class SetlistsController extends Controller
{
    public function admin()
    {
        $gig = auth()->user()->liveGig;

        if ($gig && $gig->isKareoke())
            $this->authorize('viewSetlist', $gig);

        $setlist = $gig ? $this->entries($gig) : collect();
        $musicians = Admin::musicians()->get();

        if ($gig && $gig->isShow())
            return view('pages.setlists.show.index', compact(['setlist', 'gig']));

        return view('pages.setlists.admin.index', compact(['setlist', 'gig', 'musicians']));
    }

    public function table(Request $request)
    {
        $gig = auth()->user()->liveGig;
        abort_unless($gig, 404);
        $this->authorize('viewSetlist', $gig);

        if ($request->has('newOrder')) {
            $this->authorize('reorder', $gig);

            $request->validate(['newOrder' => 'required|array|min:1']);
            // Accept both the existing Axios JSON strings and decoded object arrays.
            $order = array_map(function ($entry) {
                return is_string($entry) ? json_decode($entry, true) : $entry;
            }, $request->newOrder);
            $order = validator(['order' => $order], [
                'order.*' => 'required|array',
                'order.*.id' => 'required|integer|distinct',
                'order.*.order' => 'required|integer|min:0|distinct',
            ])->validate()['order'];

            $gig->withSetlistLock(function ($gig) use ($order) {
                $entries = $gig->setlist()->whereIn('id', array_column($order, 'id'))->get()->keyBy('id');
                abort_unless($entries->count() === count($order), 422);

                foreach ($order as $entry) {
                    $entries[$entry['id']]->update(['order' => $entry['order']]);
                }
            });

            try {
                SetlistReordered::dispatch($gig);
            } catch (\Exception $e) {
                bugreport($e);
            }
        }

        $setlist = $this->entries($gig);
        $percentage = percentage($setlist->count(), $gig->songs_limit);

        return view('pages.setlists.admin.table', compact(['setlist', 'percentage', 'gig']))->render();
    }

    protected function entries($gig)
    {
        $query = $gig->setlist()->orderBy('order')->with('song');

        if ($gig->isKareoke()) {
            $query->with(['user.admin', 'invitations' => function ($query) {
                $query->without('songRequest')->with('user.admin');
            }, 'ratings.user']);
        }

        return $query->get();
    }

    public function user()
    {
        $pastList = auth()->user()->requestsSung()->paginate(8);

        $groupList = auth()->user()->invitationsSung()->paginate(8);

        $waitingList = auth()->user()->requestsWaiting();

        return view('pages.setlists.user.index', compact(['pastList', 'waitingList', 'groupList']));    
    }
}
