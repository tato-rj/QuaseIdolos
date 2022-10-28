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
        $users = User::team()->get();

        return view('pages.team.index', compact('users'));
    }

    public function search(Request $request)
    {
        $users = $request->input ? 
            User::search($request->input)->orderBy('name')->get() :
            User::team()->get();

        return view('pages.team.results', compact('users'))->render();
    }

    public function update(Request $request, User $user)
    {
        if ($request->admin) {
            (new Admin)->grant($user, (bool) $request->super_admin);
        } else {
            (new Admin)->revoke($user);
        }

        return back()->with('success', 'O usuário foi alterado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
