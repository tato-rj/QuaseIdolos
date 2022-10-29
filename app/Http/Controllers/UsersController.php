<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::guests()->orderBy('name')->get();

        return view('pages.users.index', compact('users'));
    }

    public function show()
    {
        return view('pages.profile.index');
    }

    public function edit(User $user)
    {
        $pastList = $user->requestsSung();
        $favorites = $user->favorites;

        return view('pages.users.edit', compact(['user', 'favorites', 'pastList']));
    }

    public function update(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        
        $request->validate([
            'name' => 'string|required',
            'email' => 'email|required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return back()->with('success', 'Os seus dados foram alterados com sucesso');
    }

    public function password(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if(! \Hash::check($request->old_password, $user->password)){
            return back()->with("error", "A senha antiga não está correta!");
        }

        $user->update([
            'password' => \Hash::make($request->new_password)
        ]);

        return back()->with('success', 'A senha foi alterada com sucesso');
    }

    public function destroy(User $user = null)
    {
        $user = $user ?? auth()->user();

        $user->delete();

        return redirect(route('home'));
    }
}
