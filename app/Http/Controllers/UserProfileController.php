<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Notaris;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use function Flasher\Notyf\Prime\notyf;

class UserProfileController extends Controller
{

    public function unlock(Request $request)
    {
        $request->validate([
            'access_code' => 'required'
        ]);

        $user = auth()->user();

        // if (!$user->access_code) {
        //     return back()->with('error', 'Kode akses belum diset.');
        // }

        // if (Hash::check($request->access_code, $user->access_code)) {
        if ($request->access_code === $user->access_code) {
            // if ($request->access_code === '1234') {

            session([
                'access_all_menu' => true,
                // 'access_expires_at' => now()->addHour()
            ]);

            notyf()->position('x', 'right')->position('y', 'top')->success('Kode akses benar.');
            return back();
        }
        notyf()->position('x', 'right')->position('y', 'top')->error('Kode akses salah.');
        return back();
    }


    public function show()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $notaris = $user->notaris;
        // dd($notaris->toArray());

        return view('pages.user-profile', compact('user', 'notaris'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $credential = $request->validated();
        $credential['user_id'] = $user->id;

        // dd($credential);

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $credential['image'] = $request->file('image')->storeAs(
                'img',
                $request->file('image')->getClientOriginalName()
            );
        }

        // Jika user belum punya notaris
        if (!$user->notaris_id) {

            // Buat notaris baru
            $notaris = Notaris::create($credential);

            // Update user
            $user->update([
                'notaris_id' => $notaris->id
            ]);
        } else {

            // Update existing notaris
            $notaris = $user->notaris;

            if (!$request->hasFile('image')) {
                unset($credential['image']);
            }

            $notaris->update($credential);
        }

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil mengubah profil.');
        return redirect()->route('profile');
    }
}
