<div class="bg-white rounded-2xl shadow-sm border border-slate-100">

  <div class="flex flex-col md:flex-row md:items-center gap-5 px-5 py-4 border-b border-slate-100">

    <!-- Avatar + Upload -->
    <div class="relative">

      <img 
        src="{{ $member->profile_photo 
                ? asset('storage/'.$member->profile_photo) 
                : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
        class="w-20 h-20 rounded-full border object-cover"
        id="profile-preview">

      <form action="{{ route('profile.photo') }}" 
            method="POST" 
            enctype="multipart/form-data"
            id="photoForm">

        @csrf

        <label class="absolute -bottom-1 -right-1 bg-white border border-slate-200 
                      rounded-full px-2 py-2px text-10px cursor-pointer shadow-sm">
          Ubah
          <input type="file" 
                 name="photo" 
                 class="hidden" 
                 accept="image/*"
                 onchange="document.getElementById('photoForm').submit()">
        </label>

      </form>
    </div>

    <!-- Info utama -->
    <div class="flex-1">
      <p class="text-lg font-semibold tracking-wide uppercase">
        {{ auth()->user()->name }}
      </p>
      <p class="text-xs text-slate-500 mt-0.5">
        {{ $member->profession ?? 'Analis Kesehatan' }}
      </p>

      <div class="flex flex-wrap items-center gap-2 mt-3">
        <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1 text-[11px] font-medium">
          ● Anggota Aktif & Terverifikasi
        </span>

        <span class="inline-flex items-center rounded-full bg-slate-50 text-slate-500 border border-slate-100 px-3 py-1 text-[11px]">
          NAP: {{ $member->nap ?? '-' }}
        </span>
      </div>
    </div>

  </div>

  <!-- STATUS BAR -->
  <div class="px-5 py-3 flex flex-wrap gap-3 items-center text-[11px] text-slate-600">
    <div class="flex items-center gap-2">
      <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
      <span>Data sudah terisi 100%</span>
    </div>
    <span class="hidden sm:inline-block text-slate-300">•</span>
    <span>Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</span>
  </div>

</div>
