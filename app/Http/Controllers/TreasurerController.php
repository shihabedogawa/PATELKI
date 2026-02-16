<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Billing;
use App\Models\Invoice;
use App\Models\TreasuryBalance;
use Carbon\Carbon;
use App\Models\DuesSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class TreasurerController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['billing.member'])
            ->where('status', 'waiting')
            ->latest()
            ->get();

        $kas = TreasuryBalance::first();

        return view('admin.treasurer.index', compact('payments', 'kas'));
    }

    public function approve($id)
    {
    $payment = Payment::with('billing.member')->findOrFail($id);

    // Tandai billing sebagai lunas
    $billing = $payment->billing;
    $billing->status = 'paid';
    $billing->save();

    // Generate nomor invoice unik
    $invoiceNumber = 'INV-' . date('Ym') . '-' . Str::padLeft($billing->id, 4, '0');

    // Buat record invoice dulu (tanpa pdf_path)
    $invoice = Invoice::create([
        'billing_id' => $billing->id,
        'member_id' => $billing->member_id,
        'invoice_number' => $invoiceNumber,
        'amount' => $billing->effective_amount,   // pakai iuran dinamis
        'paid_at' => now(),
    ]);

    // Generate PDF dari Blade
    $pdf = Pdf::loadView('member.invoice-pdf', [
        'invoice' => $invoice,
        'billing' => $billing,
        'member'  => $billing->member,
    ]);

    $path = "invoices/{$invoiceNumber}.pdf";
    Storage::disk('public')->put($path, $pdf->output());

    // Update path PDF di database
    $invoice->update(['pdf_path' => $path]);

    // Hapus payment dari antrian
    $payment->delete();

    return back()->with('success', 'Pembayaran disetujui & invoice dibuat.');
    }

    public function reject($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $billing = $payment->billing;

        $payment->update(['status' => 'rejected']);
        $billing->update(['status' => 'unpaid']);

        return back()->with('error', 'Pembayaran ditolak, member harus upload ulang.');
    }

    public function storeDues(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000',
            'start_month' => 'required',
            'start_year' => 'required|integer'
        ]);

        DuesSetting::create($request->only([
            'amount','start_month','start_year','note'
        ]));

        return back()->with('success','Aturan iuran baru disimpan.');
    }

    

}
