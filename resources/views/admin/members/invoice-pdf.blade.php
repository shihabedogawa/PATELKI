<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice {{ $invoice->invoice_number }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; }
    .box { border:1px solid #ddd; padding:10px; margin-bottom:10px; }
    .title { font-size:20px; font-weight:bold; }
  </style>
</head>
<body>

<h2 class="title">INVOICE PEMBAYARAN IURAN</h2>
<p><strong>No Invoice:</strong> {{ $invoice->invoice_number }}</p>
<p><strong>Nama:</strong> {{ $member->name }}</p>
<p><strong>Bulan:</strong> {{ $billing->bulan }} {{ $billing->tahun }}</p>
<p><strong>Tanggal Bayar:</strong> {{ $invoice->paid_at->format('d M Y') }}</p>

<div class="box">
  <p><strong>Nominal:</strong> Rp {{ number_format($invoice->amount,0,',','.') }}</p>
  <p><strong>Status:</strong> LUNAS</p>
</div>

<p>Dokumen ini merupakan bukti sah pembayaran iuran.</p>

</body>
</html>
