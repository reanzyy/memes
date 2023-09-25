<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return view('auth.profile', [
            'user' => $user,
            'posts' => Post::where('user_id', $user->id)->get(),
            'currentUser' => Auth::user()
        ]);
    }

    public function show()
    {
        return view('auth.edit-profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|max:255|min:5',
            'photo' => 'nullable|image',
            'username' => 'required|alpha_num:ascii|unique:users,username,' . $user->id . '|min:5|max:255',
            'password' => 'nullable|confirmed|min:5|max:255',
            'old_password' => 'required_with:password|max:255',
        ]);


        if ($request->hasFile('photo') && !empty($request->photo)) {
            $file = $request->file('photo');
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/avatars', $fileName);

            $user->photo = "avatars/{$fileName}";
        }

        if ($request->old_password) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withError('Password lama tidak sesuai!');
            }
        }

        $user->name = $request->name;
        $user->username = $request->username;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('profile.show')->withSuccess('Profil berhasil diubah!');
    }
}