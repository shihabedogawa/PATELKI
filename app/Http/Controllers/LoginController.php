<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title'=> 'Login'
        ]);
    }

    public function store(Request $request)
    {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {

        $user = Auth::user();

        $request->session()->regenerate();

        // 1️⃣ Jika ADMIN → ke dashboard admin
        if ($user->role === 'admin') {

            if ($user->division === 'Pendidikan dan Pengembangan SDM') {
                return redirect()->route('admin.pendidikan.events.index');
            }

            if ($user->division === 'Bendahara') {
                return redirect('/admin/treasurer');
            }

            if ($user->division === 'Humas') {
                return redirect()->route('admin.humas.dashboard');
            }

            // default untuk admin lama (Organisasi/Keanggotaan/Kaderisasi)
            return redirect()->route('admin.members.pending');
        }


        // 2️⃣ Jika bukan admin tapi TIDAK punya relasi member → logout
        if (!$user->member) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun ini bukan akun anggota.']);
        }

        // 3️⃣ Jika member belum approved → tolak login
        if ($user->member->status !== 'approved') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda belum disetujui admin.']);
        }

        // 4️⃣ Jika member approved → kirim ke lengkapi profil
        if (!$user->member->is_profile_complete) {
            return redirect()->route('profile.edit');
        }

        return redirect()->route('member.dashboard');    
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }


}
