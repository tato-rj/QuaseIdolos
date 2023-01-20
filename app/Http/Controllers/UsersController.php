<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Tools\Cropper\ImageUpload;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::guests()->sortable()->paginate(12);

        return view('pages.users.index', compact('users'));
    }

    public function search(Request $request)
    {
        $users = $request->input ? User::search($request->input)->orderBy('name')->get() : collect();

        return view('pages.users.results', compact('users'))->render();
    }

    public function show()
    {
        return view('pages.profile.index');
    }

    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, User $user = null)
    {
        $this->authorize('update', $user ?? User::class);

        $user = $user ?? auth()->user();
     
        $request->validate([
            'name' => 'string|required',
            'email' => 'nullable|email',
            'avatar' => 'sometimes|max:8000|mimes:jpg,jpeg,png,webp'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'has_ratings' => $request->has_ratings ? 1 : 0
        ]);

        if ($file = $request->file('avatar'))
            $user->update(['avatar_url' => (new ImageUpload($request))->take('avatar')
                                                       ->cropped()
                                                       ->upload()]);

        return back()->with('success', 'Os seus dados foram alterados com sucesso');
    }

    public function password(Request $request, User $user = null)
    {
        $this->authorize('update', $user ?? User::class);

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

    public function destroyAvatar(User $user)
    {
        \Storage::disk('public')->delete($user->avatar_url);
        
        $user->update(['avatar_url' => null]);

        return back()->with('success', 'A sua imagem foi removida com sucesso');
    }

    public function destroy(User $user = null)
    {
        $this->authorize('update', $user ?? User::class);

        $user = $user ?? auth()->user();

        $user->favorites()->detach();

        $user->socialAccounts->each->delete();

        foreach ($user->songRequests as $songRequest) {
            $songRequest->ratings->each->delete();

            $songRequest->delete();
        }

        $user->suggestions->each->delete();

        $user->ratings->each->delete();

        $user->ratingsGiven->each->delete();

        $user->delete();

        return redirect(route('home'));
    }
}
