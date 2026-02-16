@extends('layouts.member')

@section('content')
<div class="p-6">
  <h1 class="text-2xl font-bold mb-4">Invoice Saya</h1>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @forelse($invoices as $inv)
    <div class="bg-white p-4 rounded-xl shadow">
      <p class="font-semibold">{{ $inv->invoice_number }}</p>
      <p class="text-sm text-gray-500">
        {{ $inv->billing->bulan }} {{ $inv->billing->tahun }}
      </p>
      <p class="font-bold text-blue-600 mt-2">
        Rp {{ number_format($inv->amount,0,',','.') }}
      </p>

      <a href="{{ asset('storage/'.$inv->pdf_path) }}"
         class="inline-block mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg">
        Download PDF
      </a>
    </div>
    @empty
    <p class="text-gray-500">Belum ada invoice.</p>
    @endforelse
  </div>
</div>
@endsection
