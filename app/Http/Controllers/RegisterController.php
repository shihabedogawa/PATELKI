<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
    public function index()
    {
        return view('register', [
        'title'=> 'Register'
        
        ]);
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'pendidikan' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tahun_lulus' => 'required|digits:4',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_str' => 'required|string',
            'no_ijazah' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',

            'ijazah' => 'required|file|mimes:pdf|max:200',
            'str' => 'required|file|mimes:pdf|max:200',
            'foto' => 'required|image|max:200',
        ]);

        // upload file
        $ijazah = $request->file('ijazah')->store('members/ijazah');
        $str    = $request->file('str')->store('members/str');
        // $foto   = $request->file('foto')->store('members/foto');
        $foto = $request->file('foto')->store('profile-photos', 'public');

        // simpan member
        DB::transaction(function () use ($data, $request, $ijazah, $str, $foto) {

        $member = Member::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'birthdate' => $data['tanggal_lahir'],
            'gender' => $data['jenis_kelamin'] === 'Laki-laki' ? 'male' : 'female',
            'diploma_number' => $data['no_ijazah'], // FIX
            'str_number' => $data['no_str'],
            'workplace' => $request->tempat_kerja,
            'ijazah_file' => $ijazah,
            'str_file' => $str,
            'foto_file' => $foto,
            'status' => 'pending',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'member',
            'member_id' => $member->id,
        ]);
    });

    return redirect()->back()->with('success', true);}
}
