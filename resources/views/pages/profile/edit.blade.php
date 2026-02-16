@extends('layouts.member')
@section('container')

<div class="grid grid-cols-1 lg:grid-cols-[300px_minmax(0,1fr)] gap-6 py-6">

<!-- ================= SIDEBAR PROFIL ================= -->
<aside class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6 sticky top-6 h-fit">

  <!-- FOTO & IDENTITAS -->
  <div class="text-center mb-6">

    @if(!$progress['complete'])
      <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 text-xs p-3 rounded-xl">
        ⚠️ Lengkapi data profil untuk mengakses seluruh layanan anggota.
      </div>
    @endif

    <img
      src="{{ $member->foto_file 
            ? asset('storage/'.$member->foto_file) 
            : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
      class="w-24 h-24 mx-auto rounded-full object-cover ring-4 ring-emerald-100">

    <form action="{{ route('profile.photo') }}"
      method="POST"
      enctype="multipart/form-data"
      class="mt-4">

      @csrf

      <label class="block text-xs text-slate-500 mb-2">
        Ubah Foto Profil
      </label>

      <input
        type="file"
        name="photo"
        accept="image/*"
        onchange="this.form.submit()"
        class="block w-full text-xs text-slate-500
              file:mr-3 file:py-2 file:px-4
              file:rounded-xl file:border-0
              file:text-xs file:bg-emerald-50
              file:text-emerald-700 hover:file:bg-emerald-100">

    </form>



    <h2 class="mt-4 text-xl font-bold text-slate-800">
      {{ $user->name }}
    </h2>

    <p class="text-sm text-slate-500">
      {{ $member->profession ?? 'Analis Kesehatan' }}
    </p>

    <span class="inline-block mt-3 text-xs px-4 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold">
      ● Member Aktif & Terverifikasi
    </span>
  </div>

  <!-- PROGRESS -->
  <div class="bg-slate-50 rounded-2xl p-4 mb-5">
    <div class="flex justify-between text-xs mb-1">
      <span>Kelengkapan Data</span>
      <span class="font-bold text-emerald-600">
        {{ $progress['percent'] }}%
      </span>
    </div>

    <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
      <div
        class="h-full bg-gradient-to-r from-emerald-400 to-emerald-600 transition-all"
        style="width: {{ $progress['percent'] }}%">
      </div>
    </div>

    <p class="text-[11px] text-slate-500 mt-2">
      {{ $progress['filled'] }} dari {{ $progress['total'] }} data terisi
    </p>
  </div>

  <!-- MENU -->
  <nav class="space-y-2 text-sm">
    <a href="#profil" class="block px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 font-semibold">
      👤 Profil Saya
    </a>

    <a href="#" class="block px-4 py-2 rounded-xl hover:bg-slate-50">
      📜 Riwayat Keanggotaan
    </a>

    <button
      onclick="document.getElementById('passwordModal').classList.remove('hidden')"
      class="w-full text-left px-4 py-2 rounded-xl hover:bg-slate-50">
      🔑 Ganti Password
    </button>
  </nav>

  <!-- MINI INFO -->
  <div class="grid grid-cols-2 gap-3 mt-6 text-center">
    <div class="bg-slate-50 p-3 rounded-xl">
      <p class="text-xs text-slate-500">NAP</p>
      <p class="font-semibold">{{ $member->nap ?? '-' }}</p>
    </div>

    <div class="bg-slate-50 p-3 rounded-xl">
      <p class="text-xs text-slate-500">Update</p>
      <p class="text-xs font-semibold">{{ now()->translatedFormat('d M Y') }}</p>
    </div>
  </div>

</aside>

<!-- ================= MAIN CONTENT ================= -->
<section class="space-y-6">

<!-- HEADER -->
<div class="bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-3xl p-6 text-white shadow-lg">
  <h1 class="text-2xl font-bold">Profil Anggota</h1>
  <p class="text-sm opacity-90 mt-1">
    Kelola data diri dan kartu anggota PATELKI Anda.
  </p>
</div>

<!-- FORM DATA DIRI -->
<div id="profil" class="bg-white rounded-3xl shadow border border-slate-100">

  <div class="px-6 py-4 border-b flex justify-between items-center">
    <h2 class="font-semibold text-lg">Data Diri</h2>
    <span class="text-xs px-3 py-1 rounded-full bg-emerald-50 text-emerald-700">
      Terverifikasi
    </span>
  </div>

  <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

      @foreach([
        ['Nama Lengkap','name',$user->name],
        ['Email','email',$user->email],
        ['WhatsApp','whatsapp',$member->phone],
        ['Tempat Kerja','workplace',$member->workplace],
        ['Nomor Ijazah','diploma_number',$member->diploma_number],
        ['Nomor STR','str_number',$member->str_number],
        ['Nomor SIP','sip_number',$member->sip_number],
      ] as [$label,$name,$value])
      <div>
        <label class="text-xs uppercase text-slate-500">{{ $label }}</label>
        <input name="{{ $name }}" value="{{ old($name,$value) }}"
          class="w-full border p-3 rounded-xl">
      </div>
      @endforeach

      <div>
        <label class="text-xs uppercase text-slate-500">NAP</label>
        <input value="{{ $member->nap }}" readonly
          class="w-full border p-3 rounded-xl bg-slate-100 text-slate-500 cursor-not-allowed">
        <p class="text-xs text-slate-400 mt-1">
          NAP hanya dapat diubah oleh Admin Keanggotaan
        </p>
      </div>

    </div>

    <div class="mt-6">
      <button class="bg-gradient-to-r from-emerald-600 to-emerald-500 text-white px-6 py-3 rounded-xl shadow">
        💾 Simpan Perubahan
      </button>
    </div>
  </form>
</div>

<!-- KARTU ANGGOTA -->
<div class="bg-white rounded-3xl shadow border border-slate-100">
  <div class="px-6 py-4 border-b flex justify-between items-center">
    <h2 class="font-semibold text-lg">Kartu Anggota</h2>
    <span class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">
      Aktif
    </span>
  </div>

  <div class="p-6">
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-2xl p-5 text-white shadow-lg">
      <div class="flex justify-between text-xs opacity-80 mb-3">
        <span>PATELKI</span>
        <span>DPC Singkawang</span>
      </div>

      <div class="flex items-center gap-4">
        <img src="{{ $member->foto_file 
          ? asset('storage/'.$member->foto_file) 
          : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
          class="w-14 h-14 rounded-full object-cover border-2 border-white">

        <div>
          <p class="font-bold">{{ $user->name }}</p>
          <p class="text-sm opacity-80">NAP {{ $member->nap }}</p>
        </div>
      </div>
    </div>
  </div>
</div>

</section>
</div>

<!-- MODAL GANTI PASSWORD -->
<div id="passwordModal"
     class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center">

  <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">

    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold text-slate-800">
        🔑 Ganti Password
      </h3>
      <button
        onclick="document.getElementById('passwordModal').classList.add('hidden')"
        class="text-slate-400 hover:text-slate-600">
        ✕
      </button>
    </div>

    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="text-xs uppercase text-slate-500">Password Lama</label>
        <input type="password" name="current_password"
               class="w-full border p-3 rounded-xl">
      </div>

      <div>
        <label class="text-xs uppercase text-slate-500">Password Baru</label>
        <input type="password" name="new_password"
               class="w-full border p-3 rounded-xl">
      </div>

      <div>
        <label class="text-xs uppercase text-slate-500">Konfirmasi Password</label>
        <input type="password" name="new_password_confirmation"
               class="w-full border p-3 rounded-xl">
      </div>

      <div class="flex justify-end gap-3 pt-2">
        <button type="button"
                onclick="document.getElementById('passwordModal').classList.add('hidden')"
                class="px-4 py-2 rounded-xl border text-slate-600">
          Batal
        </button>

        <button
          class="px-5 py-2 rounded-xl bg-emerald-600 text-white shadow">
          Simpan
        </button>
      </div>
    </form>

  </div>
</div>

@endsection
