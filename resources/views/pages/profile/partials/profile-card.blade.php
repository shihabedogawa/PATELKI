@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

{{-- FLASH MESSAGE --}}
@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
  {{ session('success') }}
</div>
@endif

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
  <div>
    <h1 class="text-xl sm:text-2xl font-semibold">Profil Saya</h1>
    <p class="text-xs text-slate-500 mt-1">
      Kelola data diri dan kartu anggota PATELKI Anda.
    </p>
  </div>

  <div class="flex flex-wrap gap-2">
    <button class="inline-flex items-center rounded-full border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
      Riwayat Keanggotaan
    </button>

    <a href="{{ route('profile.edit') }}"
       class="inline-flex items-center rounded-full bg-emerald-600 px-3.5 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">
      Ubah Profil
    </a>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-[minmax(0,2.3fr)_minmax(0,1fr)] gap-6">

  <!-- LEFT COLUMN -->
  <section class="space-y-5">

    @include('pages.profile.partials.profile-card')

    @include('pages.profile.partials.data-diri')

  </section>

  <!-- RIGHT COLUMN -->
  <aside class="space-y-5">

    @include('pages.profile.partials.kartu-anggota')

  </aside>

</div>

</div>
@endsection
