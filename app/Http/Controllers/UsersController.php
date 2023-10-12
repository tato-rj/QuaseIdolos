<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Tools\Cropper\ImageUpload;
use App\Rules\NotEmail;
use App\Exports\UserExport;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::guests()->withCount(['participations', 'songRequests', 'favorites', 'sentMessages', 'ratings'])->sortable()->paginate(12);

        return view('pages.users.index', compact('users'));
    }

    public function emails()
    {
        return \Excel::download(new UserExport, 'Quaseidolos emails '.now()->toDateString().'.csv');
    }

    public function search(Request $request)
    {
        $users = $request->input ? User::search($request->input)->withCount(['participations', 'songRequests', 'favorites', 'sentMessages'])->orderBy('name')->get() : collect();

        return view('pages.users.results', compact('users'))->render();
    }

    public function profile()
    {
        return view('pages.users.show.index', ['user' => auth()->user()]);
    }

    public function edit(User $user)
    {
        return view('pages.users.show.index', compact('user'));
    }

    public function info(User $user)
    {
        return view('pages.setlists.admin.tables.modals.user-info', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required', 'max:255', new NotEmail],
            'email' => 'email|required',
            'password' => 'string|required|confirmed|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password)
        ]);

        return back()->with('success', 'O usuário foi criado com sucesso');
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
            'gender' => $request->gender,
            'has_ratings' => $request->has_ratings ? 1 : 0,
            'participates_in_chat' => $request->participates_in_chat ? 1 : 0
        ]);

        if ($file = $request->file('avatar'))
            $user->update(['avatar_url' => (new ImageUpload($request))->take('avatar')
                                                       ->cropped()
                                                       ->upload()]);

        return back()->with('success', 'Os seus dados foram alterados com sucesso');
    }

    public function updateGender(Request $request, User $user)
    {
        $user->update(['gender' => $request->gender]);

        return $user->gender;
    }

    public function password(Request $request, User $user = null)
    {
        $this->authorize('update', $user ?? User::class);

        $user = $user ?? auth()->user();

        if (! auth()->user()->isSuperAdmin()) {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed',
            ]);

            if (! \Hash::check($request->old_password, $user->password)){
                return back()->with("error", "A senha antiga não está correta!");
            }
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

        $user->admin()->delete();

        $user->socialAccounts->each->delete();

        foreach ($user->songRequests as $songRequest) {
            $songRequest->ratings->each->delete();

            $songRequest->delete();
        }

        $user->receivedMessages()->delete();

        $user->sentMessages()->delete();

        $user->invitations->each->delete();

        $user->suggestions->each->delete();

        $user->participations->each->delete();

        $user->ratings->each->delete();

        $user->ratingsGiven->each->delete();

        $user->delete();

        return redirect(route('home'));
    }
}
