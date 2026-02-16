<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Billing;
use Illuminate\Support\Facades\Auth;

class MemberBillingController extends Controller
{
    public function index()
    {
        $member = Auth::user(); // pastikan user = member

        $billings = Billing::where('member_id', $member->id)
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        return view('member.tagihan', compact('billings'));
    }
}
