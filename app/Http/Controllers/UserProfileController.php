<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserProfileController extends Controller
{

    public function show()
    {
        $user = Auth::user()->load('notaris');
        $notaris = $user->notaris;

        return view('pages.user-profile', compact('user', 'notaris'));
    }


    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $notaris = $user->notaris;

        $credential = $request->validated();

        $notaris_image = $notaris->image;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada dan bukan gambar default
            if ($notaris->image && Storage::disk('public')->exists($notaris->image)) {
                Storage::delete($notaris->image);
            }
            // Simpan gambar baru
            $credential['image'] = $request->file('image')->storeAs('img', $request->file('image')->getClientOriginalName());
        } else {
            $credential['image'] = $notaris_image;
        }


        $notaris->update($credential);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil mengubah profil');
        return redirect()->route('profile');
    }
}
