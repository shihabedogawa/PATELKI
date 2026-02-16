<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Billing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberPaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'billing_ids' => 'required|array|min:1',
            'billing_ids.*' => 'exists:billings,id',
            'proof' => 'required|image|max:2048',
            'note' => 'nullable|string',
        ]);

        $member = Auth::user()->member;

        // upload bukti
        $path = $request->file('proof')->store('payment-proofs', 'public');

        foreach ($request->billing_ids as $billingId) {

            $billing = Billing::where('id', $billingId)
                ->where('member_id', $member->id)
                ->where('status', 'unpaid')
                ->first();

            if (!$billing) continue;

            Payment::create([
                'member_id'  => $member->id,
                'billing_id' => $billing->id,
                'proof_path' => $path,
                'note'       => $request->note,
                'status'     => 'waiting',
            ]);

            $billing->update(['status' => 'waiting']);
        }

        // 🔥 INI KUNCI UTAMA
        return redirect()
            ->route('member.tagihan')
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi bendahara.');
    }
}
