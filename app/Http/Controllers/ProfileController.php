<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $member = $user->member;

        return view('pages.profile.show', compact('user','member'));
    }

    public function edit()
    {
        $user = Auth::user();
        $member = $user->member;

        $progress = $member->profileCompletion();

        return view('pages.profile.edit', compact('user','member','progress'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();
        $member = $user->member;

        // VALIDASI
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,

            // 'gender' => 'required|in:male,female',
            'whatsapp' => 'nullable|string|max:20',
            'workplace' => 'nullable|string|max:255',

            'diploma_number' => 'nullable|string|max:255',
            'str_number' => 'nullable|string|max:255',
            'sip_number' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $user, $member) {
        // UPDATE USER
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // UPDATE MEMBER (NAP TIDAK DISENTUH)
        $member->update([
            // 'gender' => $request->gender,
            'phone' => $request->whatsapp,
            'workplace' => $request->workplace,
            'diploma_number' => $request->diploma_number,
            'str_number' => $request->str_number,
            'sip_number' => $request->sip_number,]);
        });

        return back()->with('success', 'Profil berhasil diperbarui.');
    }


    public function uploadPhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $member = Auth::user()->member;

    $path = $request->file('photo')->store('profile-photos', 'public');

    // hapus foto lama jika ada
    if ($member->foto_file) {
        Storage::disk('public')->delete($member->foto_file);
    }

    // PASTIKAN BENAR-BENAR TERSIMPAN
    $member->foto_file = $path;
    $member->save();

    return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Password lama salah.']);
    }

    $user->update([
        'password' => bcrypt($request->new_password),
    ]);

    return redirect()->route('profile.edit')->with('success','Foto profil berhasil diperbarui.');
}


}
