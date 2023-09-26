<?php

namespace App\Http\Controllers;

use App\Models\{Admin, User};
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = User::team()->sortable('name', 'asc')->get();

        return view('pages.team.index', compact('team'));
    }

    public function show(User $user)
    {
        if (! $user->admin()->exists())
            return redirect(route('team.index'));
        
        return view('pages.team.show', compact('user'));
    }

    public function search(Request $request)
    {
        $users = User::guests()->search($request->input)->orderBy('name')->get();

        return view('pages.team.search.table', compact('users'))->render();
    }

    public function update(Request $request, User $user)
    {
        $user->admin()->update([
            'manage_events' => $request->has('manage_events'),
            'manage_setlist' => $request->has('manage_setlist'),
            'instruments' => $request->instruments
        ]);

        return back()->with('success', 'O usuário foi alterado com sucesso');
    }

    public function grant(User $user)
    {
        $user->admin()->create();

        return back()->with('success', 'O usuário foi alterado com sucesso');
    }

    public function revoke(User $user)
    {
        $user->admin->delete();

        return back()->with('success', 'O usuário foi alterado com sucesso');
    }
}
