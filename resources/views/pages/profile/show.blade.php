@extends('layouts.member')
@section('container')

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
  {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow p-6">
  <h1 class="text-2xl font-semibold mb-2">Profil Saya</h1>
  <p class="text-sm text-slate-500 mb-4">
    Kelola data diri dan kartu anggota Anda.
  </p>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
    <div>
      <p class="text-slate-500">Nama</p>
      <p class="font-semibold">{{ $user->name }}</p>
    </div>

    <div>
      <p class="text-slate-500">Email</p>
      <p class="font-semibold">{{ $user->email }}</p>
    </div>

    <div>
      <p class="text-slate-500">NAP</p>
      <p class="font-semibold">{{ $member->nap ?? '-' }}</p>
    </div>

    <div>
      <p class="text-slate-500">Status</p>
      <p class="font-semibold text-green-600 capitalize">
        {{ $member->status }}
      </p>
    </div>
  </div>

  <div class="mt-6">
    <a href="{{ route('profile.edit') }}"
       class="inline-block bg-emerald-600 text-white px-5 py-2 rounded-lg">
      Ubah Profil
    </a>
  </div>
</div>

@endsection
