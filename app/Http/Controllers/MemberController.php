<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Invoice;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'name'           => 'required|string|max:255',
        'email'          => 'required|email|unique:members,email',
        'tanggal_lahir'  => 'required|date',
        'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
        'no_str'         => 'required|unique:members,str_number',
        'no_ijazah'      => 'required',
        'ijazah'         => 'required|file|mimes:pdf|max:2048',
        'str'            => 'required|file|mimes:pdf|max:2048',
        'foto'           => 'required|image|mimes:jpg,jpeg|max:2048',
    ]);

    $ijazahPath = $request->file('ijazah')->store('ijazah', 'public');
    $strPath    = $request->file('str')->store('str', 'public');
    $fotoPath   = $request->file('foto')->store('foto', 'public');

    Member::create([
        'name'            => $request->name,
        'email'           => $request->email,
        'nap'             => 'TMP-' . time(),
        'phone'           => '0000000000',
        'birthdate'       => $request->tanggal_lahir,
        'gender'          => $request->jenis_kelamin === 'Laki-laki' ? 'male' : 'female',
        'diploma_number'  => $request->no_ijazah,
        'no_str'      => $request->no_str,
        'status'          => 'pending',
        'ijazah_file'     => $ijazahPath,
        'str_file'        => $strPath,
        'foto_file'       => $fotoPath,
    ]);

    return back()->with('success', 'Pendaftaran berhasil! Menunggu validasi admin.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }

    public function updateNap(Request $request, $id)
    {
        $request->validate([
            'nap' => 'required|string|max:50'
        ]);

        $member = Member::findOrFail($id);
        $member->nap = $request->nap;
        $member->save();

        return back()->with('success', 'NAP berhasil diperbarui!');
    }

    public function all(Request $request)
    {
    $query = Member::query();

    // Pencarian
    if ($request->filled('search')) {
        $q = $request->search;
        $query->where(function($sub) use ($q) {
            $sub->where('name','like',"%$q%")
                ->orWhere('email','like',"%$q%")
                ->orWhere('nap','like',"%$q%");
        });
    }

    // Filter status (pending / approved)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $members = $query->latest()->paginate(10);

    return view('admin.members.all', compact('members'));
    }

    public function invoices()
    {
    $invoices = Invoice::where('member_id', auth()->user()->member->id)
        ->latest()
        ->get();

    return view('member.invoices', compact('invoices'));
    }

    public function tagihan()
    {
    $member = auth()->user()->member;

    $billings = \App\Models\Billing::where('member_id', $member->id)
        ->where('status', 'unpaid')
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get();

    return view('member.tagihan', compact('billings'));
    }

    }
