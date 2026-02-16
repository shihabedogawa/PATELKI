<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Billing;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $member = Auth::user()->member;

        // Ambil tagihan yang belum dibayar
        $unpaidBillings = Billing::where('member_id', $member->id)
            ->where('status', 'unpaid')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        return view('member.dashboard', [
            'member' => $member,
            'unpaidCount' => $unpaidBillings->count(),
            'unpaidTotal' => $unpaidBillings->sum('effective_amount'),
            'latestBills' => $unpaidBillings->take(3),
        ]);
    }
}
