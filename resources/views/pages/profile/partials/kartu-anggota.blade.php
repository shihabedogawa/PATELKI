<div class="bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col h-full">

  <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100">
    <h2 class="text-sm font-semibold">Kartu Anggota</h2>
    <span class="text-[11px] text-emerald-600">Aktif</span>
  </div>

  <div class="p-5 flex-1 flex flex-col">

    <div class="border border-slate-200 rounded-xl p-3 bg-slate-50 mb-4">
      <div class="flex items-center justify-between text-[11px] text-slate-500 mb-2">
        <span>PATELKI</span>
        <span>DPC Singkawang</span>
      </div>

      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-xs text-slate-500">
          {{ strtoupper(substr(auth()->user()->name,0,2)) }}
        </div>

        <div>
          <p class="text-xs font-semibold">{{ auth()->user()->name }}</p>
          <p class="text-[10px] text-slate-500">NAP {{ $member->nap ?? '-' }}</p>
          <p class="text-[10px] text-slate-500 mt-1">
            Berlaku s/d 31 Des 2028
          </p>`
        </div>
      </div>
    </div>

    <div class="mt-auto flex flex-col gap-2 text-xs">
      <button class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-3 py-1.5 text-white font-medium hover:bg-emerald-700">
        Unduh Kartu (PDF)
      </button>
      <button class="inline-flex items-center justify-center rounded-full border border-slate-300 px-3 py-1.5 text-slate-700 hover:bg-slate-50">
        Lihat Detail
      </button>
    </div>

    <p class="mt-3 text-[11px] text-slate-500">
      Simpan kartu anggota dalam bentuk PDF atau screenshot untuk memudahkan saat diperlukan.
    </p>
  </div>
</div>
