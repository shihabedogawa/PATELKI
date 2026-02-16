@extends('layouts.member')
@section('container')

<h1 class="text-2xl font-semibold mb-6">
    Selamat datang, {{ $member->name }} 👋
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

    {{-- STATUS --}}
    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-sm text-gray-500">Status Keanggotaan</p>
        <p class="font-semibold text-green-600 capitalize">
            {{ $member->status }}
        </p>
    </div>

    {{-- JUMLAH TAGIHAN --}}
    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-sm text-gray-500">Tagihan Belum Dibayar</p>
        <p class="text-2xl font-bold text-red-600">
            {{ $unpaidCount }} Bulan
        </p>
    </div>

    {{-- TOTAL --}}
    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-sm text-gray-500">Total Tagihan</p>
        <p class="text-2xl font-bold text-indigo-600">
            Rp {{ number_format($unpaidTotal,0,',','.') }}
        </p>
    </div>

</div>

{{-- TAGIHAN TERDEKAT --}}
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Tagihan Terdekat</h2>
        <a href="{{ route('member.tagihan') }}"
           class="text-sm text-indigo-600 hover:underline">
            Lihat Semua
        </a>
    </div>

    @if($latestBills->count())
        <ul class="divide-y">
            @foreach($latestBills as $bill)
                <li class="py-3 flex justify-between text-sm">
                    <span>
                        {{ $bill->bulan }} {{ $bill->tahun }}
                    </span>
                    <span class="font-semibold text-red-600">
                        Rp {{ number_format($bill->effective_amount,0,',','.') }}
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500 text-sm">
            Tidak ada tagihan tertunggak 🎉
        </p>
    @endif
</div>

@endsection
