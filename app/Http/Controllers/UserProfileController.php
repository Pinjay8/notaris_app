<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserProfileController extends Controller
{

    public function show()
    {
        // $user = Auth::user()->load('notaris');
        // $notaris = $user->notaris;
        $user = User::where('id', Auth::user()->id)->first();
        $notaris = $user->notaris;

        return view('pages.user-profile', compact('user', 'notaris'));
    }


    // public function update(ProfileRequest $request)
    // {
    //     $user = Auth::user();

    //     $credential = $request->validated();

    //     // Jika user belum ada notaris_id, buat notaris baru atau update relasi
    //     if (!$user->notaris_id) {
    //         // Misal kita buat record notaris baru
    //         $notaris = $user->notaris()->create($credential);

    //         $credential['image'] = $request->file('image')->storeAs('img', $request->file('image')->getClientOriginalName());

    //         // Update notaris_id di user
    //         $user->notaris_id = $notaris->id;
    //         $user->save();
    //     } else {
    //         // Update notaris existing
    //         $notaris = $user->notaris;
    //         $credential['image'] = $request->file('image')->storeAs('img', $request->file('image')->getClientOriginalName());
    //         $notaris->update($credential);
    //     }

    //     notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil mengubah profil');
    //     return redirect()->route('profile');
    // }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $credential = $request->validated();

        // Kalau user belum punya notaris_id
        if (!$user->notaris_id) {
            // Kalau ada file image, simpan
            if ($request->hasFile('image')) {
                $credential['image'] = $request->file('image')->storeAs(
                    'img',
                    $request->file('image')->getClientOriginalName()
                );
            }

            // Buat notaris baru
            $notaris = $user->notaris()->create($credential);

            // Update relasi di user
            $user->update(['notaris_id' => $notaris->id]);
        } else {
            // Update notaris existing
            $notaris = $user->notaris;

            // Kalau ada file baru, simpan dan timpa yang lama
            if ($request->hasFile('image')) {
                $credential['image'] = $request->file('image')->storeAs(
                    'img',
                    $request->file('image')->getClientOriginalName()
                );
            } else {
                // Jangan ubah field image kalau tidak ada upload baru
                unset($credential['image']);
            }

            $notaris->update($credential);
        }

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil mengubah profil.');
        return redirect()->route('profile');
    }
}
